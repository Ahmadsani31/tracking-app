<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\AuthResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        try {
            $token = JWTAuth::fromUser($user);
            return $this->sendResponse(['token' => $token, 'user' => new AuthResource($user)], 'register successfully.', 201);
        } catch (JWTException $e) {
            return $this->sendError('Error 500.', ['error' => 'Could not create token'], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!($token = JWTAuth::attempt($credentials))) {
                return $this->sendError('Unauthorised.', ['error' => 'Invalid credentials'], 401);
            }
            // Get the authenticated user.
            $user = JWTAuth::user();
            return $this->sendResponse(['token' => $token, 'user' => new AuthResource($user)], 'Login successfully.');
        } catch (JWTException $e) {
            return $this->sendError('Error 500.', ['error' => 'Could not create token'], 500);
        }
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
            return $this->sendError('Error 500.', ['error' => 'Could not create token'], 500);
        }
        return $this->sendResponse('', 'Logout Successfully.');
    }

    public function getUser()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return $this->sendError('Not Found.', ['error' => 'User not found'], 404);
            }
            return $this->sendResponse(['user' => new AuthResource($user)], 'Successfully.');
        } catch (JWTException $e) {
            return $this->sendError('Error 500.', ['error' => 'Failed to fetch user profile'], 500);
        }
    }

    public function updateUser(Request $request)
    {
        try {
            $user = Auth::user();
            $user->update($request->only(['name', 'email']));
            return $this->sendResponse(['user' => $user], 'Successfully.');
        } catch (JWTException $e) {
            return $this->sendError('Error 500.', ['error' => 'Failed to update user'], 500);
        }
    }
}
