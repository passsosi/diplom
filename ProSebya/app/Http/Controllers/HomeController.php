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
        $user = auth()->user();
        if($user != null){
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
            
            $ctrData = CasesToResult::where('t1result', $t1r)->orWhere('t2result', $t2r)->get();
            $caseData = null;
            foreach($ctrData as $el){
                $id = $el->case_id;
                $caseEl = CaseModel::where('id', $id)->get();
                $caseData[] = $caseEl[0];
            }
            $caseData = collect($caseData)->unique('id')->values()->all();
            return view('home', ['homeData' => Home::all(), 'testData'=> Test::all(), 'litData'=> Literature::all(), 'videoData'=> Video::all(), 'caseData' => $caseData]);
        }
        else{
            $caseData = null;
        }
        return view('home', ['homeData' => Home::all(), 'testData'=> Test::all(), 'litData'=> Literature::all(), 'videoData'=> Video::all(), 'caseData' => $caseData]);
    }
}