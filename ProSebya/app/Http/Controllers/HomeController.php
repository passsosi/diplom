<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Literature;
use App\models\Home;
use App\models\Test;
use App\models\Video;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function listOutput()
    {
        return view('home', ['homeData' => Home::all(), 'testData'=> Test::all(), 'litData'=> Literature::all(), 'videoData'=> Video::all()]);
    }
}