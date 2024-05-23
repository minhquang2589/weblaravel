<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    //
    public function size(){
        return view('auth.sizeguize');
    }
    
}
