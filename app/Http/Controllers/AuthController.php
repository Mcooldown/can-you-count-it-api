<?php

namespace App\Http\Controllers;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function addUser(Request $request)
    {
        $data = $request->only('username', 'email', 'password');

        UtilController::validateRequest($data, [
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make('password')
        ]);

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function authenticateUser(Request $request)
    {

        $data = $request->only('username', 'email', 'password');
        UtilController::validateRequest($data, [
            'username' => 'required_if:email,null|string',
            'email' => 'required_if:username,null|email',
            'password' => 'required|string'
        ]);

        try {
            if (!$token = JWTAuth::attempt($data)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], Response::HTTP_UNAUTHORIZED);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Could not create token'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $data = $request->only('token');
        UtilController::validateRequest($data, [
            'token' => 'required|string'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAuthUser(Request $request)
    {
        $data = $request->only('token');
        UtilController::validateRequest($data, [
            'token' => 'required|string'
        ]);

        $user = JWTAuth::authenticate($request->token);
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }
}
