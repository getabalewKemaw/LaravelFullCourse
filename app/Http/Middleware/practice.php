<?php

use GuzzleHttp\Middleware;
use Illuminate\Foundation\Testing\WithoutMiddleware;
// examples for registering the middlewares



//   to a register a diffrent middleware

// $middleware->use([
//     \App\Http\Middleware\VerifyCsrfToken::class,
//     \App\Http\Middleware\ValidateCsrfToken::class,
// ]);

// asiggn a middleawre to the routes

// Route::get("/",function(){
//     return "these  routes is assigned routes middleware";
// })->middleware(App\Http\Middleware\VerifyCsrfToken::class);



// assign mutiple middleware to the one routes

// Route::get('/MultMidd', function(){})->middleware([
//     App\Http\Middleware\VerifyCsrfToken::class,
//     App\Http\Middleware\EnsureTokenIsValid::class,
// ]);


// rempoove a middleare from the group routes


// Route::middleware([App\Http\Middleware\EnsureTokenIsValid::class])->group(function(){
//     Route::get('/name',fn()=>"ok" )->withoutMiddleware([WithoutMiddleware::class]);
// });

// //  middleware  gruops 
// ->withmiddleware(function(Middleware $middleware){
//     $middlware->('app',[
//         FirstClassmidMiddleware::class,
//         SecondClassMidMiddleware::class,
//         ]);

   
// }) ;


 // middlware aliases for shorter version of the use of middleare names 

// ->WithMiddleware(function (Middleware $middleware){
//     $middleware->aliases(
//         [
//             "ensure.token.valid"=>\App\Http\Middleware\EnsureTokenIsValid::class,
//         ]
//     )
// })


// sorting the middleares (priority  giviing the priority when orders  matters in laravele middlewares

// Route::middleware()
// ->withmiddleware(function (Middleware $middleware){
//     $middleware->priority([
//         \App\Http\Middleware\EnsureTokenIsValid::class,
//         \App\Http\Middleware\VerifyCsrfToken::class,
//     ]);
// })



// what does mean the throttle and what is the porpose of those  -it is rate limiter limit how many request and indentity (user or ip) make make in a  givene  time window