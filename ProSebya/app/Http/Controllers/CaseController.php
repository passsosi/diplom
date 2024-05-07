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
        $сase->name = $req->input('name');
        
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
                else {
                    Session::flash('status', 'В изображении кейса должен быть файл формата: png, jpg или jpeg.');
                    return redirect()->back();
                }
        }
        $case = CaseModel::latest()->first();     

        dd($req->request);

        $filteredFiles = [];
        $files = $req->files;
        foreach ($files as $name => $file) {
            if (strpos($name, 'f') !== false) {
                $filteredFiles[$name] = $file;
            }
        }
        if ($filteredFiles != null) {
            foreach ($filteredFiles as $fl) {
                $file = new CaseMaterials();
                $file->question_id = $case->id;
                $flData = file_get_contents($fl->getRealPath());
                $file->file = $flData;
                $format = $fl->getClientOriginalExtension();
                $file->format = $format;
                $name = $fl->getClientOriginalName();
                $file->name = $name;
                $file->save();
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