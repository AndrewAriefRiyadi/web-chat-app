<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Login;
use App\Livewire\Register;

Route::get('/', Login::class)->name('login')->middleware('guest');
Route::get('/register', Register::class)->name('register')->middleware('guest');
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

