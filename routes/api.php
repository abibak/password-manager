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

Route::get('/login', ['App\Http\Controllers\Auth\LoginController', 'login'])->name('login');
Route::post('/login', ['App\Http\Controllers\Auth\LoginController', 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/getUsers', ['App\Http\Controllers\Controller', 'test']);
    Route::get('logout', ['App\Http\Controllers\Controller', 'logout']);
});
