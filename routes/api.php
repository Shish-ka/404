<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/', function () {
    return response()->json('Hello api');
});

Route::controller(UserController::class)->group(function() {
    Route::get('users', 'index');
    Route::get('users/{user}', 'show');
});

