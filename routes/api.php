<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\PostController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/test',function(){
    return response()->json(['message'=>"api is working"]);
});
// to test these  visit /api/test


Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index']);                 // GET all posts
    Route::get('/{post}', [PostController::class, 'show'])->name('posts.show'); // Named route
    Route::post('/share/{post}', [PostController::class, 'share']);    // Generate share link
});


//   post api for mastering the all  about url generations
Route::prefix('users')->group(function () {
    Route::post('/unsubscribe-link/{user}', [PostController::class, 'sendUnsubscribeLink']);
    Route::get('/unsubscribe/{user}', [PostController::class, 'unsubscribe'])
        ->name('unsubscribe')
        ->middleware('signed'); // Protect signed route
});




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
