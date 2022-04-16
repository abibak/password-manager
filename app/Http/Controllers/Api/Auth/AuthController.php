<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Client\Request;
use Mockery\Exception;

class AuthController extends Controller
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

    public function getUser()
    {
        return auth()->user();
    }

    public function getUserLogins()
    {
        return $this->userRepository->getLogins();
    }

    public function logout()
    {
        return auth()->user()->currentAccessToken()->delete();
    }
}
