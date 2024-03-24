<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserSettingsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'telegram' => $user->telegram, // Предполагается наличие поля
            'dark_mode' => $user->dark_mode, // Предполагается наличие поля
        ]);
    }

    public function update(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'email' => 'sometimes|required|email|max:255|unique:users,email,' . $request->user()->id,
            'telegram' => 'nullable|string|max:255',
            'new_password' => 'sometimes|min:8',
            'current_password' => 'sometimes|required_with:new_password',
            'new_password' => 'sometimes|required_with:current_password|min:8',
            'dark_mode' => 'sometimes|boolean',
        ]); 

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }

        $user = $request->user();

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('telegram')) {
            $user->telegram = $request->telegram;
        }

        if ($request->has('dark_mode')) {
            $user->dark_mode = $request->dark_mode;
        }

        if ($request->filled('current_password') && Hash::check($request->current_password, $user->password)) {
            if ($request->filled('new_password')) {
                $user->password = Hash::make($request->new_password);
            } else {
                return response()->json(['message' => 'New password is required when changing password.'], 422);
            }
        }

        $user->save();

        return response()->json(['message' => 'Settings updated successfully.']);
    }
}
