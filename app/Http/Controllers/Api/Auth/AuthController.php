<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Request;

class AuthController extends Controller
{
    public function sendUserData()
    {
        return auth()->user();
    }

    public function logout()
    {
        return auth()->user()->currentAccessToken()->delete();
    }
}
