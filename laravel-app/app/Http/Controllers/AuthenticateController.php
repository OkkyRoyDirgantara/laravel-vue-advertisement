<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends Controller
{
    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        $validate['password'] = bcrypt($validate['password']);

        $user = User::create($validate);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json(
            [
                'user' => $user,
                'access_token' => $accessToken,
                'message' => 'success',
            ],
            200
        );
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'success'   => false,
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('ApiToken')->plainTextToken;

        $response = [
            'success'   => true,
            'user'      => $user,
            'token'     => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(
            [
                'message' => 'success',
            ],
            200
        );
    }

    public function ResetPassword(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required',
        ]);

        $user = User::where('email', $validate['email'])->first();

        if (!$user) {
            return response()->json(
                [
                    'message' => 'User not found',
                ],
                404
            );
        }

        $user->password = bcrypt('password');
        $user->save();

        return response()->json(
            [
                'message' => 'success',
            ],
            200
        );
    }
}
