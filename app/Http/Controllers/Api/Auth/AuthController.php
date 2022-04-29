<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class AuthController extends Controller
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

    public function getUser()
    {
        return $this->userRepository->getUserByEmail(auth()->user()->email);
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
