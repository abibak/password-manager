<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrganizationLoginController;

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
    Route::get('/getUser', ['App\Http\Controllers\Api\Auth\AuthController', 'getUser']);
    Route::get('/logout', ['App\Http\Controllers\Api\Auth\AuthController', 'logout']);

    /* api resource routes */
    Route::apiResource('organization/login', OrganizationLoginController::class);
    Route::apiResource('access/folder', 'App\Http\Controllers\Api\AccessOrganizationFolderController');
    Route::apiResource('user/folder', 'App\Http\Controllers\Api\UserFolderController');
    Route::apiResource('user/login', 'App\Http\Controllers\Api\UserLoginController');
    Route::apiResource('organization/folder', 'App\Http\Controllers\Api\OrganizationFolderController');
});
