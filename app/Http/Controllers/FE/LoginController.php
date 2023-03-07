<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return redirect(url('/masterdata/products'));
        // if (session()->get('login')) {
        //     return redirect(url('/dashboard/contacts'));
        // } else {
        //     return redirect(url('login'));
        // }
    }

    public function login()
    {
        return view('auth.login');
    }
}
