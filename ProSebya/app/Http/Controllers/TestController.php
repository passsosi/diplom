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
            $i = 1;
            $b = 0;
            // объявляем переменные номера вопроса и количества баллов

            foreach($req->answers as $el){ // пересчет ответов
                if($i % 2 != 0){ // проверяем номер вопроса на чётность
                    if($el > 3){ // если ответ положительный - добавляем балл
                        $b = $b + 1;
                    }
                } else { // ответ нечётный
                    if($el < 4){ // ответ отрицательный
                        $b = $b + 1; // добавляем балл
                    }
                }
                $i = $i + 1; // номер вопроса + 1
            }
            
            if($b > 7){
                if($b > 14){
                    $s = "Высокий уровень внушаемости";
                }
                else
                {
                    $s = "Средний уровень внушаемости";
                }
            }
            else
            {
                $s = "Низкий уровень внушаемости";
            }
            // присваеваем уровень внушаемости в зависимости от количества баллов
    
            $user = auth()->user(); // получаем данные пользователя
            $user->update([
                'test1resultINT' => $b,
                'test1resultSTRING' => $s,
            ]);
            // присваеваем результаты теста соответствующему пользователю

            return view('compTestPage', [
            'req' => $req,
            'tData' => $test_id,
            'tMData' => $tm_id,
            'b' => $b,
            's' => $s
            ]);
        }

        elseif($tm_id == 2) // если id метода равно 2
        {
            $i = 1;
            $b = 0;
            // объявляем переменные
            foreach($req->answers as $el){
                switch ($i) {
                    case 1:
                    case 9:
                    case 11:
                    case 14:
                    case 16:
                    case 20:
                    case 21:
                    case 22:
                        $b += $el;
                    break;
                    // если номер вопроса равен 1, 9, 11 и тд., добавляем в баллы соответствующее значение ответа
                    default: // если номер вопроса не совпадает с необходимыми
                        switch($el){
                            case 1:
                                $b += 6;
                            break;
                            case 2:
                                $b += 5;
                            break;
                            case 3:
                                $b += 4;
                            break;
                            case 4:
                                $b += 3;
                            break;
                            case 5:
                                $b += 2;
                            break;
                            case 6:
                                $b += 1;
                            break;
                            // добавляем в баллы обратные от ответав значения
                        }
                    break;
                }
                $i++;
            }
            
            if($b > 60){
                if($b > 99){
                    $s = "Высокий уровень толерантности";
                }
                else
                {
                    $s = "Средний уровень толерантности";
                }
            }
            else
            {
                $s = "Низкий уровень толерантности";
            }
            // присваеваем результаты теста соответствующему пользователю
    
            $user = auth()->user();
            $user->update([
                'test2resultINT' => $b,
                'test2resultSTRING' => $s,
            ]);
    
            return view('compTestPage', [
            'req' => $req,
            'tData' => $test_id,
            'tMData' => $tm_id,
            'b' => $b,
            's' => $s
            ]);
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