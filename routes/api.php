<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/', function () {
    return 'Hello api';
});
Route::fallback(function () {
    return response()->json([
        "message"=> "Not found",
        "code"=> 404
    ], 404);
});
