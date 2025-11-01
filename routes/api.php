<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\Post1Controller;
use App\Http\Controllers\ValidationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SessionController;

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



Route::prefix('session')->group(function () {
    Route::post('/login', [SessionController::class, 'login']);                  // create session (auth sim)
    Route::post('/logout', [SessionController::class, 'logout']);                // invalidate session
    Route::get('/profile', [SessionController::class, 'profile']);              // read session user
    Route::post('/regenerate', [SessionController::class, 'regenerate']);       // regenerate ID
    Route::post('/invalidate', [SessionController::class, 'invalidate']);       // invalidate session (regenerate+flush)
    Route::post('/cart/add', [SessionController::class, 'addToCart']);          // push value into session array
    Route::get('/cart', [SessionController::class, 'viewCart']);                // read cart
    Route::post('/flash', [SessionController::class, 'flashMessage']);          // set flash
    Route::get('/flash', [SessionController::class, 'getFlash']);              // get flash
    Route::post('/cache/put', [SessionController::class, 'sessionCachePut']);  // put value into session cache
    Route::get('/cache/get', [SessionController::class, 'sessionCacheGet']);

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


// these is all about validations in php
Route::post('/validator',[ValidationController::class,'register']);



// a simple book api for mastering the php artisan console using the tinker  



Route::apiResource('books', BookController::class);


Route::get('/posts1', [Post1Controller::class, 'index']);
Route::post('/posts1', [Post1Controller::class, 'store']);


// all about the Lazy collections

use App\Http\Controllers\UserExportController;

Route::get('/users/export', [UserExportController::class, 'export']);
