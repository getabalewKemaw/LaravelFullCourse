<?php

namespace App\Http\Controllers;

use App\Models\gech;
use Illuminate\Http\Request;

class GechController extends Controller
{
    

    public function index(){
         $data=new gech();
        $data->name="getabalew";
        $data->department="sw";
        $data->age=30;
        $data->save();



        $datas=gech::get();
        dd($datas);


        


    }
}
