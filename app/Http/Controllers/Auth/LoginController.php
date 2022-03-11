<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request, UserRepository $userRepository)
    {
        $user = $userRepository->getUserByEmail($request->email);

        if ($user && Hash::check($request->password, $user->master_password)) {
            Auth()->attempt(['email' => $request->email, 'password' => $request->password]);

            return response()->json([
                'user' => $user,
                'access_token' => $user->createToken($request->email)->plainTextToken,
            ]);
        }
    }
}
