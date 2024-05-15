<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\models\User;

class UserController extends Controller
{
    public function userOutput()
    {
        $users = User::all();
        return view('users', [
        'users' => $users,
        ]);
    }
}