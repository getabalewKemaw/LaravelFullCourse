<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public function showForm(){
        return view('form');
    }
    public function handleForm(Request $request){
        return "form submitted successfully by ".$request->name;
    }
}

