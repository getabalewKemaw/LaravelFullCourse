<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/test',function(){
    return response()->json(['message'=>"api is working"]);
});
// to test these  visit /api/test





Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::post('/users/upload', [UserController::class, 'upload']);
Route::get('/users/headers', [UserController::class, 'headers']);
Route::post('/users/info', [UserController::class, 'info']);
