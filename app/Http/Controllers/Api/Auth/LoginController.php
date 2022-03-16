<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request, UserRepository $userRepository)
    {
        $rules = [
            'email' => 'bail|required',
            'password' => 'bail|required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['messages' => $validator->errors()], 401);
        }

        $user = $userRepository->getUserByEmail($request->email ?? '');

        if (Auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'user' => $user,
                'access_token' => $user->createToken($request->email)->plainTextToken,
            ], 200);
        }

        return response()->json(['messages' => 'User not found'], 401);
    }
}
