<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request, UserRepository $userRepository)
    {
        $rules = [
            'email' => 'bail|required|string',
            'password' => 'bail|required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['messages' => $validator->errors()], 400);
        }

        $user = $userRepository->getUserByEmail($request->email);

        if ($user && $user->is_blocked) {
            return response()->json(['message' => ['error' => ['Ошибка входа']]], 401);
        }

        if (Auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'user' => $user,
                'access_token' => $user->createToken($request->email)->plainTextToken,
            ], 200);
        }

        throw new UserNotFoundException('Введены неверные данные');
    }
}
