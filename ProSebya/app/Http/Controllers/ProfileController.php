<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\models\User;

class ProfileController extends Controller
{
    public function profileOutput()
    {
        $user = auth()->user();

        return view('profile', [
        'user' => $user,
        ]);
    }

    public function compView($id)
    { 
        return view('compTestPage', [
        'req' => $req
        ]);
    }
}