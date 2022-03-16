<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/login', ['App\Http\Controllers\Api\Auth\LoginController', 'login'])->name('login');
Route::post('/login', ['App\Http\Controllers\Api\Auth\LoginController', 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    /* api resource routes */
    Route::apiResource('user/folders/', 'App\Http\Controllers\Api\UserFolderController');
    Route::get('/getAuth', ['App\Http\Controllers\Api\Auth\AuthController', 'sendUserData']);
    Route::get('logout', ['App\Http\Controllers\Api\Auth\AuthController', 'logout']);
});
