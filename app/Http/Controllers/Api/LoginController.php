<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserLogin;
use App\Services\LoginService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private $loginService;

    public function __construct()
    {
        $this->loginService = new LoginService(new UserLogin);
    }

    public function getFavoritesPassword()
    {
        return $this->loginService->getFavoritesPassword();
    }
}
