<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/custom-endpoint', function () {
    return response()->json(['message' => 'This is a custom API endpoint']);
});

