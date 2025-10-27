<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
  public function sayHello(){
    return view('hello.welcome',['name1'=>"getch the great"])->with('lastName',"kemaw");
  }
}
