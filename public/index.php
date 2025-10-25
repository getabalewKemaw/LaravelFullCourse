<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());


// the function of the index.php   is create the appa and load the laravel and finallay sed request to the kernel

// then the function of the kernel if handle the request  and it is the central manager of every request
// it has two  main function mainly
//  1 load  all the bootsrapes  ( for logging ,error handling nad the like things)
//  2 run the middlewares stack - it means it is the security gard that filter who filll the requirement  and  who not  before they reach the routes 

// the next step in laravel service  life cycle is services providers those are like the persom that  do some some tasks in the application  like  registring  event listeners  ,routing ,validation  and the like things
// it is class that registres and boots all laravel features
// it has two main phases
// registers  phase - it registers all the things that is needed for the service container 
// boot phase - execute the logic that depend on the  services being ready
// step 4 Routing and the main controller 
// onces the system is booted the next step is  laarvel checks the routes  that match the url then if 
// if thre is a middleware executes that first 
// if  it perfom and pass the criteria then move to the main businnes logic (controllers) runs
// the final step is sendign the requset back to the browser