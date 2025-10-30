<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view('home')->with(compact(['user']));
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
