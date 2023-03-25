<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/password/reset', 'App\Http\Controllers\AuthController@resetPassword');
Route::post('/password/email', 'App\Http\Controllers\AuthController@sendResetLinkEmail');

// User account routes
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::put('/user', 'App\Http\Controllers\UserController@update');
});

// Seller routes
Route::group(['middleware' => ['jwt.auth', 'role:seller']], function () {
    Route::resource('plants', 'App\Http\Controllers\PlantsController')->except(['create', 'edit']);
});

// Customer routes
Route::get('/plants', 'App\Http\Controllers\PlantsController@index');
Route::get('/plants/{id}', 'App\Http\Controllers\PlantsController@show');

// Admin routes
Route::group(['middleware' => ['jwt.auth', 'role:admin']], function () {
    Route::resource('categories', 'App\Http\Controllers\CategoriesController')->except(['create', 'edit']);
    Route::get('/', 'App\Http\Controllers\AuthController@index');
    Route::get('/{id}', 'App\Http\Controllers\AuthController@show');
    Route::put('/approve-seller/{id}', 'UserController@approveSeller');
});
Route::group(['middleware' => ['jwt.auth', 'role:admin']], function () {
    Route::resource('categories', 'App\Http\Controllers\CategoriesController')->except(['create', 'edit']);
    Route::resource('plants', 'App\Http\Controllers\PlantsController')->except(['create', 'edit']);
    Route::put('/users/{id}/roles', 'App\Http\Controllers\AuthController@updateRoles');
});