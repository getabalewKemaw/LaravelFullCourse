<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SingleAction extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // these is a single action controleller it is used for  when the task is needed only one fuction and when we those 
        // in the routes we do need to  write the fucntion a name  it genetally invakable by laravel
   
     return "these is demonestratesn a single action  controllers  ";
    }
}
