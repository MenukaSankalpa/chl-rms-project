<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function login(){
        return view('help.login');
    }
    public function user_manual(){
        return view('help.user_manual');
    }
}
