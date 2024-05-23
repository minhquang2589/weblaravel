<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Middleware\CustomCheckRole;


class AdminController extends Controller
{
    //
    public function index(){
        return view('admin.dashboard');
    }
}
