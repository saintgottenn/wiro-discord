<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users',
            'telegram' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'telegram' => $request->telegram,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Определение, является ли идентификатор адресом электронной почты
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // Попытка аутентификации
        if (!Auth::attempt([$fieldType => $request->login, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // Получение пользователя и создание токена
        $user = User::where($fieldType, $request->login)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {   
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Tokens Revoked'
        ]);
    }
}
