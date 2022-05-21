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
        try {
            $user = $this->userRepository->getUserByEmail(auth()->user()->email);

            if ($user) {
                return response()->json($user, 200);
            }

            throw new \Exception('User not found');
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    public function logout()
    {
        return auth()->user()->currentAccessToken()->delete();
    }
}
