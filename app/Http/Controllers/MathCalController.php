<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MathCalController extends Controller
{
    // these controller do  sum and subctarction of the numbers

    public function Add($a,$b){
        return "the sum is ".($a+$b);
    }
    public function Substract($a,$b){
        return "the diffrence  is ".($a-$b);
        
    }
}
