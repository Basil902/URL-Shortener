<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserControler;
use App\Http\Controllers\UserController;
use Illuminate\Container\Attributes\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');

Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');

Route::post('/login', [AuthController::class, 'login'])->name('login.authenticate');

Route::post('/logout', [AuthController::class, 'logout'])
->name('auth.logout')
->middleware('auth');

Route::get('/profile', [UserControler::class, 'profile'])
->name('user.profile')
->middleware('auth');