<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;

Route::get('/errorPage', function () {
    return view('errorPage');
});

Route::get('/file-outpute/{id}', [FileController::class, 'file_preview'])->name('file-output');

Route::get('/casepage/{id}', [CaseController::class, 'caseOutput'])->name('casepage');

Route::post('/{cid}/caseResult', [CaseController::class, 'caseResult'])->name('caseResult');

Route::get('/{cid}/case-result', [CaseController::class, 'userCaseResult'])->name('case-result');

Route::get('/caseCreate', [CaseController::class, 'caseCreateView'])->name('caseCreateView');

Route::post('/caseCreate', [CaseController::class, 'caseCreate'])->name('caseCreate');

Route::get('/testpage/{id}', [TestController::class, 'testOutput'])->name('testpage');
    
Route::get('/', [HomeController::class, 'ListOutput'])->name('home');

Route::post('/{tid}/{tmid}/testResult', [TestController::class, 'testResult'])->name('testResult');

Route::get('/{tid}/{tmid}/compTestPage', [TestController::class, 'compView'])->name('compTestPage');

Route::get('/profile', [ProfileController::class, 'profileOutput'])->name('profile');

Route::get('/user-profile/{id}', [ProfileController::class, 'userProfile'])->name('user-profile');

Route::get('/users', [UserController::class, 'userOutput'])->name('users');

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
