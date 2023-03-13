<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        if (session()->get('login')) {
            if(session()->get('userRole') == 'tender'){
                return redirect(url('/tender/submission-form/'.session()->get('userTender')));
            } else
            return redirect(url('/projects'));
        } else {
            return redirect(url('/login'));
        }
    }

    public function login()
    {
        return view('auth.login');
    }
}
