<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Define routes that require authentication with JWT
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::resource('categories', 'App\Http\Controllers\CategoriesController');
    Route::resource('plants', 'App\Http\Controllers\PlantsController');
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/register', 'App\Http\Controllers\AuthController@register');