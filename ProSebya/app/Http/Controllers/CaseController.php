<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\CaseModel;
use App\models\CaseQuestion;
use App\models\CaseMaterials;
use App\models\CaseAnswer;
use App\models\CasesToResult;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\models\User;

class CaseController extends Controller
{
    public function caseOutput($id)
    {
        if (Auth::check()) {
        $cData = CaseModel::where('id', $id)->get();
        $qData = CaseQuestion::where('case_id', $id)->get();
        $mData = CaseMaterials::whereIn('question_id', $qData->pluck('id'))->get();
        $aData = CaseAnswer::whereIn('caseQuestion_id', $qData->pluck('id'))->get();
        if(isset($qData[0])){
            return view('casePage', [
                'cData' => $cData,
                'mData' => $mData,
                'qData' => $qData,
                'aData' => $aData
                ]);
        }
        else{
            return redirect('/errorPage');
        }
        }
        else{
            return redirect(route('home'))->withErrors(['err' => 'Вы не вошли в аккаунт']);
        }
    }

    public function caseCreateView()
    {
        if (Auth::check()) {
            return view('caseCreatePage');   
        }
        return redirect('/');
    }

    public function caseCreate(Request $req)
    {       
        $сase = new CaseModel();
        if($req->input('name') != null){
            $сase->name = $req->input('name');
        }
        else{
            Session::flash('status', 'Пожалуйста введите название кейса');
            return redirect()->back();
        }
        
        if($req->file('image') != null)
        {
            $img = $req->file('image');
                if ($img->getClientOriginalExtension() == 'png' || $img->getClientOriginalExtension() == 'jpeg' || $img->getClientOriginalExtension() == 'jpg')
                {
                   $imgData = file_get_contents($img->getRealPath());
                    $image = $imgData;
                    $сase->preview = $image;
                    $сase->save();
                }
                // Если файл не является картинкой
                else {
                    Session::flash('status', 'В изображении кейса должен быть файл формата: png, jpg или jpeg.');
                    return redirect()->back();
                }
        }
        // Если нет файла для превью кейса
        else{
            Session::flash('status', 'Необходимо выбрать изображение кейса! (форматы: png, jpg или jpeg.)');
            return redirect()->back();
        }

        $case = CaseModel::latest()->first();
        $recs = $req->input('recs');
        foreach ($recs as $rec) {
            $ctr = new CasesToResult();
            $ctr->case_id = $case->id;
            if (strpos($rec, 'толерантности') === false) {
                if (strpos($rec, 'внушаемости') === false) {
                    // Нет соответствий
                    Session::flash('status', 'Хотел расколоть орех, но что-то пошло не так');
                    return redirect()->back();
                } else {
                    // Слово "внушаемости" присутствует в текущем элементе $rec
                    $ctr->t1result = $rec;
                }
            } else {
                // Слово "толерантности" присутствует в текущем элементе $rec
                $ctr->t2result = $rec;
            }
            $ctr->save();
        }
        $i = 0;
        $filteredFiles = [];
        $files = $req->files;
        foreach ($files as $name => $file) {
            if (strpos($name, 'f') !== false) {
                $filteredFiles[] = $file;
            }
        }
        $curTable = "";
        $items = $req->request;
        foreach ($items as $name => $item)
        {
            if (strpos($name, 'q') !== false) {
                $curTable = "questions";
                $question = new CaseQuestion();
                $question->text = $item;
                $question->case_id = $case->id;
                $question->save();
                if ($filteredFiles[$i] != null) {
                        $fl = $filteredFiles[$i];
                        $question = CaseQuestion::latest()->first();
                        $file = new CaseMaterials();
                        $file->question_id = $question->id;
                        $flData = file_get_contents($fl->getRealPath());
                        $file->file = $flData;
                        $format = $fl->getClientOriginalExtension();
                        $file->format = $format;
                        $name = $fl->getClientOriginalName();
                        $file->name = $name;
                        $file->save();
                        $i++;
                }
            }
            if (strpos($name, 'answer') !== false) {
                $curTable = "answers";
                $question = CaseQuestion::latest()->first();
                $answer = new CaseAnswer();
                $answer->text = $item;
                $answer->caseQuestion_id = $question->id;
                $answer->save();
            }
        }
       

        dd('succes');
        // return view('update', [
        //     'data' => $data,
        //     'images' => $images,
        //     'documents' => $docs,
        //     'category' => $category,
        //     'itemCategory' => $itemCategory
        // ]);   
    }
}