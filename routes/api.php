<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\LocalizationController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Post1Controller;
use App\Http\Controllers\RateLimitDemoController;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\WeatherController;
use App\Models\User;
use App\Notifications\UserAlertNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SessionController;


use Illuminate\Support\Facades\Mail;
use App\Mail\SimpleMail;


use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\AnalayticsController;

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


// simulation of laravel concurrency

Route::get('/stats', [AnalyticsController::class, 'index']);
Route::post('/track', [AnalayticsController::class, 'track']);



Route::post('/register1',[UserController::class,'register']);


//all about file handling 

Route::prefix('/files')->group(function () {
    Route::post('/upload', [FileController::class, 'upload']);
    Route::get('/list', [FileController::class, 'listFiles']);
    Route::get('/download/{filename}', [FileController::class, 'download']);
    Route::get('/temp-url/{filename}', [FileController::class, 'temporaryUrl']);
    Route::post('/move/{filename}', [FileController::class, 'moveFile']);
    Route::post('/copy/{filename}', [FileController::class, 'copyFile']);
    Route::delete('/delete/{filename}', [FileController::class, 'deleteFile']);
});

// the ff are alla bout the http clinets  it include  wether tracking dashboards

Route::post('/weather', [WeatherController::class, 'fetch']);


// all about localization and translation  usign the laravel lanf property 


Route::get('/welcome', [LocalizationController::class, 'welcome']);
Route::get('/order', [LocalizationController::class, 'order']);
Route::get('/notifications', [LocalizationController::class, 'notifications']);


//mailign in  laravel using the  smtp serve




Route::post('/send-email', function (Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'email' => 'required|email',
        'message' => 'required|string|max:500',
    ]);

    Mail::to($validated['email'])->send(new SimpleMail($validated));

    return response()->json(['status' => '✅ Email sent successfully!']);
});



// all about notification

Route::post('/notify', function () {
    $user = User::first(); // simple: send to first user
    $message = request('message', 'This is a test notification!');
    
    $user->notify(new UserAlertNotification($message));

    return response()->json([
        'status' => 'Notification sent!',
        'to' => $user->email,
        'message' => $message
    ]);
});


// all about quee in  laravel for the porpsoe of  to remove  the delays   and for the porpose of  to handle the long running tasks 

Route::post('/quee',[UserController::class,'register1']);


// usign the rate limiter in laravel for the limiting the number of requests  and for security porposes


Route::get('/send-message', [RateLimitDemoController::class, 'sendMessage']);
Route::get('/reset-limit', [RateLimitDemoController::class, 'reset']);

// all about task schedulign in laravel it is basicallyused for  doing some repetitive tasks every time  (we can customize the times)


Route::get('/trigger-cleanup', function () {
    Artisan::call('logs:clean');
    Log::info('🧹 [Manual API] Log cleanup triggered manually!');
    return response()->json(['message' => 'Cleanup command executed manually.']);
});