<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;

Route::get('/testpage/{id}', [TestController::class, 'testOutput'])->name('testpage');
    
Route::get('/', [HomeController::class, 'ListOutput'])->name('home');

Route::post('/{tid}/{tmid}/testResult', [TestController::class, 'testResult'])->name('testResult');

Route::get('/{tid}/{tmid}/compTestPage', [TestController::class, 'compView'])->name('compTestPage');

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/');
    }
    return view('auth/login');
})->name('login');
 
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::get('/logout', function () {
     Auth::logout();
    return redirect('/');
});

Route::get('/register', function () {

        return view('auth/register');

    return redirect('/');
})->name('register');

Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
