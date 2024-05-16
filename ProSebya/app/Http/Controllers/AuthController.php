<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users',
            'password' => ['required', 'string', 'min:8'],
        ]);
        $role = 1;
        $imgReq = $request->file('image');
        if($imgReq != null){
            $img = file_get_contents($imgReq->getRealPath());
        }
        else{
            $imagePath = "images/emptyImage.jpg";
            $imageData = file_get_contents($imagePath);
            $img = $imageData;
        }

        $age = (int)$request->input('age');
        if (!$age) {
            return redirect(route('register'))->withErrors(['age' => 'Укажите возраст целым числом']);
        }


        $user = new User([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'patronymic' => $request->input('patronymic'),
            'age' => $age,
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'user_role' => $role,
            'image' => $img
        ]);
        $user->save();

        //event(new Registered($user));

        Auth::login($user);

        return redirect('/');
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        $formFields = $request->only('email', 'password');

        if (Auth::attempt($formFields)) {
            return redirect('/');
        }

        return redirect(route('login'))->withErrors(['email' => 'Неверный логин или пароль']);
    }
}
