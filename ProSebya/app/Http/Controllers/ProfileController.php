<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\models\User;
use App\models\CaseResult;
use App\models\CaseModel;

class ProfileController extends Controller
{
    public function profileOutput()
    {
        $user = auth()->user();

        return view('profile', [
        'user' => $user,
        ]);
    }

    public function userProfile($user_id)
    {
        $user = User::where('id', $user_id)->get();
        $caseResult = caseResult::where('user_id', $user_id)->get();
        $cases = [];
        $i = 0;
        foreach($caseResult as $el){
            if($i === 0 || $cases[$i-1] != $el->case_id){
                $cases[$i] = $el->case_id;
                $i++;
            }
        }
        $case = CaseModel::whereIn('id', $cases)->get();
        return view('user-profile', [
        'user' => $user[0],
        'cases' => $case
        ]);
    }

    public function compView($id)
    { 
        return view('compTestPage', [
        'req' => $req
        ]);
    }
}