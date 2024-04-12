<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Literature;
use App\models\Home;
use App\models\Test;
use App\models\Video;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\models\User;
use App\models\CaseModel;
use App\models\CasesToResult;

class HomeController extends Controller
{
    public function listOutput()
    {
        $user = auth()->user(); // получаем данные о пользователе
        if($user != null){ // проверяем массив на наличие данных
            if($user->test1resultSTRING != null){ 
                $t1r = $user->test1resultSTRING;
            }
            else{
                $t1r = "none"; 
            }
            if($user->test2resultSTRING != null){
                $t2r = $user->test2resultSTRING;
            }
            else{
                $t2r = "none"; 
            }
            // получаем результаты пройденных тестов в переменные
            
            $ctrData = CasesToResult::where('t1result', $t1r)->orWhere('t2result', $t2r)->get(); // получаем id кейсов, в которых рекомендованы соответствующие результаты

            $caseData = null;
            foreach($ctrData as $el){
                $id = $el->case_id;
                $caseEl = CaseModel::where('id', $id)->get();
                $caseData[] = $caseEl[0];
            }
            // получаем кейсы с соответствующим id

            $caseData = collect($caseData)->unique('id')->values()->all();
            // исключаем повторения

            return view('home', ['homeData' => Home::all(), 'testData'=> Test::all(), 'litData'=> Literature::all(), 'videoData'=> Video::all(), 'caseData' => $caseData]);
            // возвращаем на представление все необходимые данные
        }
        else{
            $caseData = null;
        }
        return view('home', ['homeData' => Home::all(), 'testData'=> Test::all(), 'litData'=> Literature::all(), 'videoData'=> Video::all(), 'caseData' => $caseData]);
    }
}