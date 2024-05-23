<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Test;
use App\models\Question;
use App\models\Answer;
use App\models\TestMethod;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\models\User;

class TestController extends Controller
{
    public function testOutput($id)
    {
        if (Auth::check()) { // если пользователь авторизован

        $tData  = Test::where('id', $id)->get();
        $tMData = TestMethod::where('id', $tData[0]->textMethod_id)->get();
        $qData = Question::where('test_id', $id)->get();
        $aData = Answer::all();
        // получаем данные

        if(isset($qData[0])){
            return view('testPage', [
                'tData' => $tData,
                'tMData' => $tMData,
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

    public function testResult(Request $req, $test_id, $tm_id)
    {
        if($tm_id == 1) // если id методики равно 1
        {
            $numQuestion = 1;
            $point = 0;
            // объявляем переменные номера вопроса и количества баллов

            foreach($req->answers as $el){ // пересчет ответов
                if($numQuestion % 2 != 0){ // проверяем номер вопроса на чётность
                    if($el > 3){ // если ответ положительный - добавляем балл
                        $point = $point + 1;
                    }
                } else { // ответ нечётный
                    if($el < 4){ // ответ отрицательный
                        $point = $point + 1; // добавляем балл
                    }
                }
                $numQuestion = $numQuestion + 1; // номер вопроса + 1
            }
            
            if($point > 7){
                if($point > 14){
                    $str = "Высокий уровень внушаемости";
                    $txt = "Угроза вовлечения в экстремистские организации, как и в иные тоталитарные объединения, очень велика!!!";
                }
                else
                {
                    $str = "Средний уровень внушаемости";
                    $txt = "Человек с такими значениями теста кому-то что-то внушает, и сам поддается внушению - все зависит от состояния человека, ситуации и его вовлеченности в ситуацию, ее значимости для человека.";
                }
            }
            else
            {
                $str = "Низкий уровень внушаемости";
                $txt = "У вас есть четкая система принципов и ценностей, вы хорошо понимаете, чего хотите от жизни и в чем ваши интересы, вами трудно манипулировать.";
            }
            // присваеваем уровень внушаемости в зависимости от количества баллов
    
            $user = auth()->user(); // получаем данные пользователя
            $user->update([
                'test1resultINT' => $point,
                'test1resultSTRING' => $str,
            ]);
            // присваеваем результаты теста соответствующему пользователю

            return view('compTestPage', [
            'req' => $req,
            'tData' => $test_id,
            'tMData' => $tm_id,
            'b' => $point,
            's' => $str,
            'txt' => $txt
            ]);
        }

        elseif($tm_id == 2) // если id метода равно 2
        {
            $numQuestion = 1;
            $point = 0;
            // объявляем переменные
            foreach($req->answers as $el){
                switch ($numQuestion) {
                    case 1:
                    case 9:
                    case 11:
                    case 14:
                    case 16:
                    case 20:
                    case 21:
                    case 22:
                        $point += $el;
                    break;
                    // если номер вопроса равен 1, 9, 11 и тд., добавляем в баллы соответствующее значение ответа
                    default: // если номер вопроса не совпадает с необходимыми
                        switch($el){
                            case 1:
                                $point += 6;
                            break;
                            case 2:
                                $point += 5;
                            break;
                            case 3:
                                $point += 4;
                            break;
                            case 4:
                                $point += 3;
                            break;
                            case 5:
                                $point += 2;
                            break;
                            case 6:
                                $point += 1;
                            break;
                            // добавляем в баллы обратные от ответав значения
                        }
                    break;
                }
                $numQuestion++;
            }
            
            if($point > 60){
                if($point > 99){
                    $str = "Высокий уровень толерантности";
                    $txt = "Представители этой группы обладают выраженными чертами толерантной личности.";
                }
                else
                {
                    $str = "Средний уровень толерантности";
                    $txt = "Для вас характерно сочетание как толерантных, так и интолерантных черт. В одних социальных ситуациях вы ведёте себя толерантно, в других можете проявлять интолерантность.";
                }
            }
            else
            {
                $str = "Низкий уровень толерантности";
                $txt = "Ваши результаты свидетельствуют о выраженных интолерантных установках по отношению к окружающему.";
            }
            // присваеваем результаты теста соответствующему пользователю
    
            $user = auth()->user();
            $user->update([
                'test2resultINT' => $point,
                'test2resultSTRING' => $str,
            ]);
    
            return view('compTestPage', [
            'req' => $req,
            'tData' => $test_id,
            'tMData' => $tm_id,
            'b' => $point,
            's' => $str,
            'txt' => $txt
            ]);
        }
        elseif($tm_id == 3) // если id метода равно 2
        {
            $numQuestion = 1;
            $point = 0;
            foreach($req->answers as $el){ // пересчет ответов
                if($numQuestion <= 6){
                    if($el > 3){ 
                        $point = $point + 1;
                    }
                } elseif($numQuestion <= 12){ 
                    if($el < 4){
                        $point = $point + 1; 
                    }
                }elseif($numQuestion <= 18){ 
                    if($el < 4){
                        $point = $point + 1; 
                    }
                }elseif($numQuestion <= 24){ 
                    if($el < 4){
                        $point = $point + 1; 
                    }
                }elseif($numQuestion <= 30){ 
                    if($el < 4){
                        $point = $point + 1; 
                    }
                }elseif($numQuestion <= 36){ 
                    if($el < 4){
                        $point = $point + 1; 
                    }
                }elseif($numQuestion <= 42){ 
                    if($el < 4){
                        $point = $point + 1; 
                    }
                }elseif($numQuestion <= 48){ 
                    if($el < 4){
                        $point = $point + 1; 
                    }
                }elseif($numQuestion <= 54){ 
                    if($el < 4){
                        $point = $point + 1; 
                    }
                }elseif($numQuestion <= 60){ 
                    if($el < 4){
                        $point = $point + 1; 
                    }
                }elseif($numQuestion <= 66){
                    if($el < 4){
                        $point = $point + 1; 
                    }
                }
                $numQuestion = $numQuestion + 1; // номер вопроса + 1
            }
        }
    }

    public function compView($id)
    { 
        return view('compTestPage', [
        'req' => $req,
        'tData' => $test_id,
        'tMData' => $tm_id
        ]);
    }
}