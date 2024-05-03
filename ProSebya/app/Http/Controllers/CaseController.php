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
        dd($req);

        $сase = new CaseModel();
        $сase->name = $req->input('name');

        if($req->file('image') != null)
        foreach ($req->file('image') as $img){
            $image = $сase->preview;
            $imgData = file_get_contents($img->getRealPath());
            $image = $imgData;
        }
        
        $сase->save();
        $сase = Item::latest()->first();     

        if ($req->file('file') != null) {
            foreach ($req->file('file') as $fl) {
                $file = new CaseMaterials();
                $file->question_id = $item->id;
                $flData = file_get_contents($fl->getRealPath());
                $file->file = $flData;
                $format = $fl->getClientOriginalExtension();
                $file->format = $format;
                $name = $fl->getClientOriginalName();
                $file->name = $name;
                $file->save();
            }
        }

        $data = Item::findOrFail($item->id);
        $images = Image::where('id_item', $item->id)->get();
        $docs = Documents::where('id_item', $item->id)->get();
        $category = TCtg::all();
        $itemCategory = TCtg::where('id', $data->id_category)->get();

        return view('update', [
            'data' => $data,
            'images' => $images,
            'documents' => $docs,
            'category' => $category,
            'itemCategory' => $itemCategory
        ]);   
    }

}