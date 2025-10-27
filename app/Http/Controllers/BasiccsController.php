<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BasiccsController extends Controller
{
    // in a single controlelr we  can declare multiple files for diffrent porpose  and we can  use  in the routes like a group and used for doffremt routes

    public function Header(){
        return "these is a headre componennt";
    }

    public function MainTask(){
        return "these is a basics a  the applications main task are here";
    }

    public function contact(){
        return "these is a contact page  controller -> or the business logic sin the comtect routes";
    }
}
