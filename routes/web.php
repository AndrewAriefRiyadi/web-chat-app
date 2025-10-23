<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Login;
use App\Livewire\Register;

Route::get('/', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');
Route::get('/home', function(){
    return view('home');
})->name('register');
