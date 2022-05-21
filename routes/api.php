<?php

use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
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
    Route::get('user/account/deactivate/{id}',
        ['App\Http\Controllers\Api\UserController', 'changeStatusDeactivateAccount']);
    Route::get('role/change/status/{status}', ['App\Http\Controllers\Api\RoleController', 'changeRoleStatus']);

    // password history route
    Route::post('login/action', ['App\Http\Controllers\Api\OrganizationLoginController', 'action']);

    // password favorite routes
    Route::get('organization/login/favorite/change/{id}',
        ['App\Http\Controllers\Api\OrganizationLoginController', 'changeStatusFavorite']);
    Route::get('user/login/favorite/change/{id}',
        ['App\Http\Controllers\Api\UserLoginController', 'changeStatusFavorite']);

    Route::get('/login/favorites', ['App\Http\Controllers\Api\LoginController', 'getFavoritesPassword']);

    Route::post('/folder/access/change', ['App\Http\Controllers\Api\AccessOrganizationFolderController', 'changeAccessStatus']);

    /* auth routes */
    Route::get('/getUser', ['App\Http\Controllers\Api\Auth\AuthController', 'getUser']);
    Route::get('/logout', ['App\Http\Controllers\Api\Auth\AuthController', 'logout']);

    /* api resource routes */
    Route::apiResource('role', RoleController::class);
    Route::apiResource('user/account', UserController::class);
    Route::apiResource('organization/login', OrganizationLoginController::class);
    Route::apiResource('access/folder', 'App\Http\Controllers\Api\AccessOrganizationFolderController');
    Route::apiResource('user/folder', 'App\Http\Controllers\Api\UserFolderController');
    Route::apiResource('user/login', 'App\Http\Controllers\Api\UserLoginController');
    Route::apiResource('organization/folder', 'App\Http\Controllers\Api\OrganizationFolderController');
});
