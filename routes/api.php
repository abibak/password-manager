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
    /* auth routes */
    Route::get('/getAuth', ['App\Http\Controllers\Api\Auth\AuthController', 'sendUserData']);
    Route::get('logout', ['App\Http\Controllers\Api\Auth\AuthController', 'logout']);

    /* api resource routes */
    Route::apiResource('/access/folder', 'App\Http\Controllers\Api\AccessOrganizationFolderController');
    Route::apiResource('user/folder', 'App\Http\Controllers\Api\UserFolderController');
    Route::apiResource('user/login', 'App\Http\Controllers\Api\UserLoginDataController');
    Route::apiResource('user/organization/folder', 'App\Http\Controllers\Api\OrganizationFolderController');
});
