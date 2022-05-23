<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


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

    public function passwordVerification(Request $request)
    {
        $dataUser = $this->userRepository->getPasswordCurrentUser();

        if (Hash::check($request->oldPassword, $dataUser->password) &&
            !Hash::check($request->newPassword, $dataUser->password) &&
            $request->newPassword === $request->repeatPassword)
        {
            return $this->changePassword($request->newPassword);
        }

        return $this->changePassword();
    }

    public function changePassword(string $newPassword = '')
    {
        try {
            if ($newPassword && $this->userRepository->updatePasswordCurrentUser($newPassword)) {
                return response()->json(['message' => 'Success update password'], 200);
            }

            throw new \Exception('Error update password');
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function logout()
    {
        return auth()->user()->currentAccessToken()->delete();
    }
}
