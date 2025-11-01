<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
class UserExportController extends Controller
{

    public function export(Request $request){
    $cached =Cache::get('exported_user');
    if($cached){
        Log::info("returned user from the catche");
        return response()->json(['from_cache'=>true,'data'=>$cached]);   
    }

    // use the lazy collection to handle large  dataset
      $users = User::lazy()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_active' => $user->is_active,
            ];
        })->all();

         // 3️⃣ Cache result for 10 minutes
        Cache::put('exported_users', $users, now()->addMinutes(10));

        Log::info('🆕 Cached new user export data');

        // 4️⃣ Return JSON response
        return response()->json(['from_cache' => false, 'data' => $users]);

    }
    // check if the   data is catched

}
