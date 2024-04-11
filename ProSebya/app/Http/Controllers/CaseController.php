<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\CaseModel;
use App\models\CaseQuestion;
use App\models\CaseMaterials;
use App\models\CaseAnswer;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\models\User;

class CaseController extends Controller
{
    public function caseOutput($id)
    {
        if (Auth::check()) {
        $cData  = CaseModel::where('id', $id)->get();
        $qData = CaseQuestion::where('case_id', $id)->get();
        $mData = CaseMaterials::all();
        $aData = CaseAnswer::all();

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

}