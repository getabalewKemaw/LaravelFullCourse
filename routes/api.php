<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FeedbackController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/test',function(){
    return response()->json(['message'=>"api is working"]);
});
// to test these  visit /api/test




Route::get('/feedback', [FeedbackController::class, 'index']);          // JSON Response
Route::post('/feedback', [FeedbackController::class, 'store']);         // JSON + Status
Route::get('/feedback/{id}', [FeedbackController::class, 'show']);      // Response + Header
Route::get('/feedback/download/{id}', [FeedbackController::class, 'download']); // File response
Route::get('/feedback/report', [FeedbackController::class, 'report']);  // Stream response
Route::get('/feedback/redirect', [FeedbackController::class, 'redirectDemo']); // Redirect




Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::post('/users/upload', [UserController::class, 'upload']);
Route::get('/users/headers', [UserController::class, 'headers']);
Route::post('/users/info', [UserController::class, 'info']);
