<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http;
class HttpControllers extends Controller
{

    // these is all about the  http controller  and its methods

// adding  the  filtera nd the  extra paginationss

public function index(Request $request){
    $res=Http::get('https:://getch.com',['page'=>2,'staus'=>'active']);

    // the above one is the tradional ways so the modetn ways is the with query paramaeters methid

    Http:withQueryParametrs([
        'page'=>1,'status'=>'active'
    ])->get('https://getch.com');

    // sending  the data across  the apis using the  post,put,and patch methosd
//unless we specify the  types of the data to be sent the defualt is the application./json but u  can customiz e that to what ever u want 

    $res1=Http::post('https://getch.com',['name'=>'getch','email'=>'getabalewkemaw@gmail.com']);

    // simple file uploads using the http atatch property
    $res2=Http::attach('avatar',file_get_contents('me.jpg'),'me.jpg')->post('https://getch.com');// it is used when we send the data to another devices

    // Headers are alos th emain benefits of the backend applications it is all about the the contract b/n the api and what data is accesptd and also the secury mechanism are all these  in with headrs methods

    $head1=Htttp::withHeaders(['Authorixation'=>'Bearer'.$token=0,
    'Accept'=>'appication/json'])->get('https://getch.com');


    // making the urls dynamin using the withurlParametes

    $dynamiurl=Http::withUrlParameters(['endpoint'=>"https://getch.com",'resource'=>'users','dept'=>"softwareenginnering"])->get('{endpoint}/{resource}/?department={dept}');

    // for debugging purposes it is better to  use the dd methods  that is dumpling requests

    // the retry methods  is used when the api is failed and  allows back retrys lets do that
    // for eg if the endpiont faiks some  issues withe the server lets do siple exmplease right server  300ms for 3times   it is better when the api is fallled 
// use  the macro methods when we want resusable anc clean api integrtions
// 
//  
$pay=Http::macro('stripe',function(){
    return Http::withToken(config('services.stripe.secret')
    ->baseUrl('https://stripe.api.com/v1'));
});
// then we can call every where we want

$stripe=Http::stripe()->get('/customers');
}

}
