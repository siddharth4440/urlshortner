<?php

use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::middleware(['auth'])->group(function () {
    Route::resource('/companies', CompanyController::class)->names('companies');

    Route::resource('/users', UserController::class)->names('users');

    Route::resource('/urls', ShortUrlController::class)->names('urls');
});
