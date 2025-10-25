<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
     public function index()
     {
        // i get the class not found eror for view so how to solve that

        if(!View::exists("main.home")){
            dump("the view does not exists");
        }
        return view("main.home");
     }
}
