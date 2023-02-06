<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Projects extends Controller
{
    public function index()
    {
        return view('projects.list');
    }

    public function form($id){
        return view('projects.form', ['id' => $id]);
    }

    public function new(){
        return view('projects.form', ['id' => null]);
    }
}
