<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

// Route::get('/', function () {
//     return Inertia::render('welcome', [
//         'canRegister' => Features::enabled(Features::registration()),
//     ]);
// })->name('home');

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('dashboard', function () {
//         return Inertia::render('dashboard');
//     })->name('dashboard');
// });

// Route::get('/about',function(){
//     $person=["name"=>"getabalew","age"=>23];
//     /* dump($person);
//     dd($person); */
//     return view('about');

// });

// Route::get('/', function () {
//     return view('welcome');
// });
Route::view('/about-us','about')->name(('about'));;
// require __DIR__.'/settings.php';
//route paarmeters
Route::get("/products/{id}",function($id){
    return  "Product id is : ".$id;
});
//simple com,plex examples

Route::get("/products/{id}/reviews/{reviewId}",function($id,$reviewId){
    return  "Product id is : ".$id." and review id is : ".$reviewId;
});
// route optional parameters 
Route::get("/products/catagory/{category?}",function($category=null){
  return "products with category :$category";
});
//some valiodation
Route::get("/users/{id}",function($id){
return "UserName is :$id";
})->whereNumber('id');

//writeAlpha,writeAlphanumeric

Route::get("/users1/{name}",function($name){
    return "the name is :$name";
})->whereAlphaNumeric('name');
//but the write alpha method is for only strings 
// two paremters validaions

Route::get("/users2/{name}/abc/{id}",function($id,$name){
    return "the name is :$name and the id is :$id";
})->whereAlpha('name')
 ->whereNumber('id');

 //regex validation logix
 // lets   validate the user name  greaterthan 2 alpha numeric  and the like logics 
Route::get("/users3/{name}/abc/{id}",function($id,$name){
  return "the name is :$name and the id is :$id";
})->where('name','[A-Za-z]{2,}')
 ->whereNumber('id');
 //named routes
 //assocites a name to a routes 

 Route::get('/',function(){
    $aboutPageUrl='about';
    $aboutPageUrl=route('about');
    // dd($aboutPageUrl);
 });
 // route names and links with paaremters
 // redirection in laravel routs

 // redirect to  the current user from .porfile

 Route::view("/user/profile","profile")->name("profile");
Route::get("/user/CurrentUser",function(){
  return redirect()->route('profile');

});
//route Grops  in laravel 
//1 using the prefix and th group methods 

Route::prefix("/admin")->group(function(){
   Route::get('/dashboard',function(){
    return "this is what admin/dashboard";
   });
   Route::get("stats",function(){
    return "this is  admin/stats page usig the GroupRoutings";
   });


});
// fall back routes when  the user get 404 of pages these function is executed

Route::fallback(function(){
    return "OOps there is not maching u r result please check where u press the link ";
});

Route::get("/sum/{a}/{b}",function($a,$b){
    return "the sum is :".$a+$b;
})->whereNumber(['a','b']);;
// get all the routes usign the php artisam php artisan route:list

Route::get('/cars',[App\Http\Controllers\CarController::class,'index']);
Route::get("/showcar",App\Http\Controllers\ShowCarController::class);
// creating  the route for the resources

Route::resource('/products',App\Http\Controllers\ProdController::class);// u can use the only  and  and execep to filter the methods in the   resooure the controller

// craeting  the routes for my math cal controller
Route::get("/sum2/{a}/{b}",[App\Http\Controllers\MathCalController::class,'Add'])->whereNumber(['a','b']);
Route::get("/diffrence/{a}/{b}",[App\Http\Controllers\MathCalController::class,'Substract'])->whereNumber(['a','b']);
Route::get('/',[HomeController::class,'index'])->name('home');

//for the form class practicing the csrf 
Route::get('/submit-form',[FormController::class,'showForm']);
Route::post('/submit-form',[FormController::class,'handleForm']);


// the laravel routing componet allow  all charcters except  / to be present on the route parameter so if we need to do that
// Route::get('/search/{query}',function(string $query){
//     return "Search results for: $query";
// })->where('query','.*');




Route::get('/profileGetch', function () {
    return "Secret profile page of getabalew";
})->middleware('token'); // using alias


Route::get('/api/data', function () {
    return response()->json(['data'=>'ok']);
})->middleware('token');
