<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\models\User;
use App\models\CaseMaterials;
use LaravelFileViewer;
use File;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{

public function file_preview($id){

    $file = CaseMaterials::find($id);
    $format = $file->format;
    $blobData = $file->file;
    $filename = $file->name;
    file_put_contents("file." . $format, $blobData);
    //$filepath='public/'.$filename;
    $filePath = public_path("file." . $format);
    $file_url=asset('file.' . $format);
    $file_data=[
        [
          'label' => __('Название'),
          'value' => $filename
        ]
      ];
    return LaravelFileViewer::show($filename,$filePath,$file_url,$file_data);
    }
}