<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidationController extends Controller
{
    // these is for the master if php backend api valiadtions using the registearttin forms   

public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|min:3|max:50',
        'email' => 'required|email',
        'password' => 'required|min:6',
    ], [
        'name.required' => 'Please provide your full name.',
        'email.required' => 'Email is required.',
    ]);

    if ($validator->fails()) { // ✅ correct spelling
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

    return response()->json([
        'status' => true,
        'message' => 'Validation passed! 🎉',
        'data' => $validator->validated(),
    ]);
}

}
 