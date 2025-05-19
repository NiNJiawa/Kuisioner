<?php

use App\Http\Controllers\AdminController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuestionnaireController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/questionnaire', [QuestionnaireController::class, 'index'])->name('questionnaire.index');
    Route::post('/questionnaire', [QuestionnaireController::class, 'store'])->name('questionnaire.store');
    Route::get('/questionnaire/result', [QuestionnaireController::class, 'result'])->name('questionnaire.result');
    Route::post('/questionnaire/save-temp', [QuestionnaireController::class, 'saveTemp'])->name('questionnaire.save_temp');
});

Route::middleware(['auth', IsAdmin::class])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/user/{id}', [AdminController::class, 'show'])->name('admin.show');
});

