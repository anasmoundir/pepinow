<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Authentication routes
Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::post('/login', 'App\Http\Controllers\AuthController@login')->name('login');
Route::post('/forgot-password', 'App\Http\Controllers\AuthController@forgotPassword');
Route::post('/reset-password/{token}', 'App\Http\Controllers\AuthController@resetPassword');


Route::post('/logout', 'App\Http\Controllers\AuthController@logout');
Route::get('/getPlantByCategory/{id}', 'App\Http\Controllers\PlantsController@getPlantsByCategory');

// Routes that require authentication
Route::group(['middleware' => 'jwt.auth'], function () {
    // User routes
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('makeSeller/{id}', 'App\Http\Controllers\manageAccounts@makeSeller');
    Route::post('makeAdmin/{id}', 'App\Http\Controllers\manageAccounts@makeAdmin');
  
    Route::post('/password/reset', 'App\Http\Controllers\AuthController@resetPassword');
    Route::post('/password/email', 'App\Http\Controllers\AuthController@sendResetLinkEmail');
    Route::put('/profile', 'App\Http\Controllers\AuthController@updateProfile');
    Route::put('/password', 'App\Http\Controllers\AuthController@updatePassword');
    // Plants routes
    Route::get('/plants', 'App\Http\Controllers\PlantsController@index');
    Route::get('/plants/{id}', 'App\Http\Controllers\PlantsController@show');
    Route::post('/plants', 'App\Http\Controllers\PlantsController@store');
    Route::put('/plants/{id}', 'App\Http\Controllers\PlantsController@update');
    Route::delete('/plants/{id}', 'App\Http\Controllers\PlantsController@destroy');

    // Categories routes
    Route::resource('categories', 'App\Http\Controllers\CategoriesController');
});