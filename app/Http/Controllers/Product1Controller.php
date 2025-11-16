<?php

namespace App\Http\Controllers;
use App\Models\Product1;
use Illuminate\Http\Request;
class Product1Controller extends Controller
{
    public function  store(Request $request){
        $product1=Product1::create($request->all());
        return response()->json([
            'message'=>"products created ",
            'data'=>$product1
        ]);


    }

    // list all  producst
    public function index(){
        return Product1::all();
    }

    // show a   single product

    public function show(Product1 $product1){
        return $product1;
    }

}
