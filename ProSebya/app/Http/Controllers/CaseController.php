<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\CaseModel;
use App\models\CaseQuestion;
use App\models\CaseMaterials;
use App\models\CaseAnswer;
use App\models\CasesToResult;
use App\models\CaseResult;
use App\models\Risk;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\models\User;

class CaseController extends Controller
 {
    public function caseOutput( $id )
 {
        if ( Auth::check() ) {
            $user = auth()->user();
            $caseResult = caseResult::where( 'user_id', $user->id )->get();
            foreach ( $caseResult as $el ) {
                if ( $el->case_id == $id ) {
                    return redirect( route( 'home' ) )->withErrors( [ 'err' => 'Вы уже прошли этот кейс' ] );
                }
            }
            $cData = CaseModel::where( 'id', $id )->get();
            $qData = CaseQuestion::where( 'case_id', $id )->get();
            $mData = CaseMaterials::whereIn( 'question_id', $qData->pluck( 'id' ) )->get();
            $aData = CaseAnswer::whereIn( 'caseQuestion_id', $qData->pluck( 'id' ) )->get();
            if ( isset( $qData[ 0 ] ) ) {
                return view( 'casePage', [
                    'cData' => $cData,
                    'mData' => $mData,
                    'qData' => $qData,
                    'aData' => $aData
                ] );
            } else {
                return redirect( '/errorPage' );
            }
        } else {
            return redirect( route( 'home' ) )->withErrors( [ 'err' => 'Вы не вошли в аккаунт' ] );
        }
    }

    public function caseCreateView()
 {
        if ( Auth::check() ) {
            return view( 'caseCreatePage' );

        }
        return redirect( '/' );
    }

    public function caseCreate( Request $req )
 {
        $user = auth()->user();
        // если пользователь авторизирован
        if ( $user->user_role == 2 || $user->user_role == 3 ) {
            // если пользователь достоин

            $сase = new CaseModel();
            // получаем модель таблицы case
            if ( $req->input( 'name' ) != null ) {
                // проверка на наличие названия в инпуте
                $сase->name = $req->input( 'name' );
                // получаем имя кейса из инпута и присвоиваем имени в модели
            } else {
                Session::flash( 'status', 'Пожалуйста введите название кейса' );
                // если названия нет
                return redirect()->back();
            }

            if ( $req->file( 'image' ) != null ) // провверка на наличие изображения кейса
            {
                $img = $req->file( 'image' );
                // получаем изображение из инпута
                if ( $img->getClientOriginalExtension() == 'png' || $img->getClientOriginalExtension() == 'jpeg' || $img->getClientOriginalExtension() == 'jpg' ) // проверка на совпадение типов изображения
                {
                    $imgData = file_get_contents( $img->getRealPath() );
                    // получем изображение в формате LONGBLOB
                    $image = $imgData;
                    $сase->preview = $image;
                    // присвоиваем в изображение модели
                    $сase->save();
                }
                // Если файл не является картинкой
                else {
                    Session::flash( 'status', 'В изображении кейса должен быть файл формата: png, jpg или jpeg.' );
                    return redirect()->back();
                }
            }
            // Если нет файла для превью кейса
            else {
                Session::flash( 'status', 'Необходимо выбрать изображение кейса! (форматы: png, jpg или jpeg.)' );
                return redirect()->back();
            }
            // кейс сохранился, получаем его из таблицы
            $case = CaseModel::latest()->first();
            $recs = $req->input( 'recs' );
            // получаем значение тестовых инпутов
            foreach ( $recs as $rec ) {
                $ctr = new CasesToResult();
                // получаем значения рекомендаций
                $ctr->case_id = $case->id;
                if ( strpos( $rec, 'толерантности' ) === false ) {

                    if ( strpos( $rec, 'внушаемости' ) === false ) {
                        // Нет соответствий
                        Session::flash( 'status', 'Хотел расколоть орех, но что-то пошло не так' );
                        return redirect()->back();
                    } else {
                        // Слово 'внушаемости' присутствует в текущем элементе $rec
                        $ctr->t1result = $rec;
                    }
                } else {
                    // Слово 'толерантности' присутствует в текущем элементе $rec
                    $ctr->t2result = $rec;
                }
                $ctr->save();
            }
            $i = 0;
            $filteredFiles = [];
            $files = $req->files;
            foreach ( $files as $name => $file ) {
                // отсортировываем файлы для вопросов от изображения кейса
                if ( strpos( $name, 'f' ) !== false ) {
                    $filteredFiles[] = $file;
                }
            }
            $curTable = '';
            $items = $req->request;
            $risk_count = 0;
            $risk = $req->input( 'risk' );
            foreach ( $items as $name => $item ) //сортировка текст инпутов в зависимости от названия
            {
                if ( strpos( $name, 'q' ) !== false ) {
                    // это текст вопроса
                    $curTable = 'questions';

                    $question = new CaseQuestion();
                    $question->text = $item;
                    $question->case_id = $case->id;
                    $question->save();
                    //сохраняем
                    if ( $filteredFiles[ $i ] != null ) {
                        // если есть файл - добавляем с привязкой к вопросу
                        $fl = $filteredFiles[ $i ];
                        //$question = CaseQuestion::latest()->first();
                        $file = new CaseMaterials();
                        $file->question_id = $question->id;
                        $flData = file_get_contents( $fl->getRealPath() );
                        $file->file = $flData;
                        $format = $fl->getClientOriginalExtension();
                        $file->format = $format;
                        $name = $fl->getClientOriginalName();
                        $file->name = $name;
                        $file->save();
                        // сохраняем
                        $i++;
                    }
                }
                if ( strpos( $name, 'answer' ) !== false ) {
                    // это тексты ответов к данному вопросу
                    $curTable = 'answers';
                    //$question = CaseQuestion::latest()->first();
                    $answer = new CaseAnswer();
                    $answer->text = $item;
                    $answer->caseQuestion_id = $question->id;
                    $answer->risk = $risk[$risk_count];
                    $answer->save();
                    $risk_count++;
                    // сохраняем
                }
            }
            return redirect( '/' );
        } else {
            return redirect( route( 'home' ) )->withErrors( [ 'err' => 'Вы не можете создавать кейсы' ] );
            // если пользователь не достоин
        }
    }

    public function caseDelete( $id ) 
 {
        $user = auth()->user();
        // если пользователь авторизирован
        if ( $user->user_role == 2 || $user->user_role == 3 ) // если пользователь достоин
 {
            $caseResult = caseResult::where( 'case_id', $id )->get();
            $cData = CaseModel::where( 'id', $id )->get();
            $qData = CaseQuestion::where( 'case_id', $id )->get();
            $mData = CaseMaterials::whereIn( 'question_id', $qData->pluck( 'id' ) )->get();
            $aData = CaseAnswer::whereIn( 'caseQuestion_id', $qData->pluck( 'id' ) )->get();
            $CtR = CasesToResult::whereIn( 'case_id', $qData->pluck( 'id' ) )->get();

            CaseAnswer::whereIn( 'caseQuestion_id', $qData->pluck( 'id' ) )->delete();
            CaseMaterials::whereIn( 'question_id', $qData->pluck( 'id' ) )->delete();
            CaseQuestion::where( 'case_id', $id )->delete();
            CasesToResult::whereIn( 'case_id', CaseModel::where( 'id', $id )->pluck( 'id' ) )->delete();
            CaseModel::where( 'id', $id )->delete();
            caseResult::where( 'case_id', $id )->delete();
            return redirect( '/' );

        } else {
            return redirect( '/' );
        }
    }

    public function caseResult( Request $req, $case_id )
 {
        $user = auth()->user();
        // получаем данные пользователя
        $answer_count = 0;
        $answer_sum = 0;
        foreach ( $req->answers as $el ) {
            // перебираем ответы пользователяя
            $caseResult = new caseResult();
            $answer = CaseAnswer::where( 'id', $el )->get();
            $risk = $answer[0]->risk;
            $question_id = $answer[ 0 ]->caseQuestion_id;
            $caseResult->user_id = $user->id;
            $caseResult->answer_id = $el;
            $caseResult->question_id = $question_id;
            $caseResult->case_id = $case_id;
            $caseResult->save();
            // сохраняем
            $answer_count++;
            $answer_sum = $answer_sum + $risk;
        }
        $riskResult = $answer_sum/$answer_count;
        if($riskResult <= 1){
            $riskSTRING = "Низкие риски";
        }
        if($riskResult <= 2 && $riskResult > 1){
            $riskSTRING = "Средние риски";
        }
        if($riskResult > 2){
            $riskSTRING = "Высокие риски";
        }
        $userRisk = new Risk();
        $userRisk->user_id = $user->id;
        $userRisk->case_id = $case_id;
        $userRisk->riskSTRING = $riskSTRING;
        $userRisk->save();
        return redirect( '/' );
    }

    public function userCaseResult( $user_id, $case_id )
 {
        $int_case_id = ( int ) $case_id;
        $int_user_id = ( int ) $user_id;
        $caseResult = caseResult::where( 'case_id', $int_case_id )->where( 'user_id', $int_user_id )->get();
        $user = User::where( 'id', $user_id )->get();
        $FIO = $user[ 0 ]->name . ' ' . $user[ 0 ]->surname . ' ' . $user[ 0 ]->patronymic;
        $case = CaseModel::where( 'id', $case_id )->get();
        $case_name = $case[ 0 ]->name;
        $answers = CaseAnswer::whereIn( 'id', $caseResult->pluck( 'answer_id' ) )->get();
        $questions = CaseQuestion::whereIn( 'id', $caseResult->pluck( 'question_id' ) )->get();
        return view( 'user-case-result', [ 'caseResult' => $caseResult, 'FIO' => $FIO, 'caseName' => $case_name, 'answers'=> $answers, 'questions' => $questions ] );
    }
}