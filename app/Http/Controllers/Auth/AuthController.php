<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function sendUserData()
    {
        return auth()->user();
    }
}
