<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/custom-endpoint', function () {
    return response()->json(['message' => 'This is a custom API endpoint']);
});



// routes groups for some things 

Route::middleware(['auth','verfied'])->group(function(){
    Route::get('/dashboard/{id}',function(){
      return "these  is protected group routes ";
    });
    Route::get('/profile',function(){
        return "this is profile page";
    });

});


// if money routes are in the same controllers u can use the controller methods

Route::controller(App\Http\Controllers\CarController::class)->group(function(){
    Route::get('/cars','index');
    // Route::get('/cars/{id}','show');
    // you can add more routes here that use CarController
});


// domain routing is used for multi tenacy application
Route::domain('api.example.com')->group(function(){
    Route::get('/info',function(){
        return response()->json(['message'=>"this is from the api subdomain"]);
    });
});

// ROUTE name prefixes

Route::name('admin')->group(function(){
    Route::get('/dashboard',function(){
        return "these is  admin dashboards"; 
    })->name('.dashboard');
    // dump(route('admin.dashboard'));

});
// so you can access this route by using route('admin.dashboard') admin/dashboard

// implicit binding -automaticcaly injects values from the databses

// Route::get('/users/{user}',function(App\Models\User $user){
//     return "User email is : ".$user->email;
// });

// custom key binding
// insteadc of id  we can use slug for other columns
// Route::get('/posts/{post:slug}',function(App\Models\Post $post){
//     return "Post title is : ".$post->title;
// });