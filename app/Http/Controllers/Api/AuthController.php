<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use http\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register new user.
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'phone_number' => $request->phone_number,
                'email_verified_at' => now()
            ]);

            if ($user) {
                return ResponseHelper::success(
                    message: 'User has been Registered Successfully !',
                    data: $user,
                    statusCode: 201);
            }
            return ResponseHelper::error(
                message: 'Unable To Register user Please try again !',
                statusCode: 400);


        } catch (Exception $e) {
            \Log::error('Unable to Register User : ' . $e->getMessage() . ' - Line no. ' . $e->getLine());
            return ResponseHelper::error(
                message: 'Unable To Register user Please try again !' . $e->getMessage(),
                statusCode: 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function login(LoginRequest $request)
    {
        try {
            /**
             * if credentials are incorrect
             */
            if (!Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ])) {
                return ResponseHelper::error(
                    message: 'Unable To Login ! due to invalid credentials ',
                    statusCode: 400);
            }
            $user = Auth::user();

            /**
             * Create Api Token
             * This Code get Api Tokens
             */
            $token = $user->createToken('My Api Token ')->plainTextToken;

            $authUser = [
                'user' => $user,
                'token' => $token
            ];
            return ResponseHelper::success(
                message: 'You are Logged in Successfully !',
                data: $authUser,
                statusCode: 200);
        } catch (Exception $e) {
            \Log::error('Unable to Login User : ' . $e->getMessage() . ' - Line no. ' . $e->getLine());

            return ResponseHelper::error(
                message: 'Unable To Login ! Please try again !' . $e->getMessage(),
                statusCode: 500);
        }
    }

    /**
     * function : Auth User data / Profile Data
     * @param NA
     * @return JsonResponse
     */
    public function userProfile()
    {
        try {
            $user = Auth::user();
            if ($user) {
                return ResponseHelper::success(
                    message: 'User Profile Fetched Successfully !',
                    data: $user,
                    statusCode: 200);
            }
            return ResponseHelper::error(
                message: 'Unable fetch user data ! due to invalid token ',
                statusCode: 400);

        } catch (Exception $e) {
            \Log::error('Unable To Fetch User Profile Data ' . $e->getMessage() . ' - Line no. ' . $e->getLine());

            return ResponseHelper::error(
                message: 'Unable To Fetch User Profile Data ! Please try again !' . $e->getMessage(),
                statusCode: 500);
        }
    }

    public function userLogout()
    {
        try {
            $user = Auth::user();
            if ($user) {
                $user->currentAccessToken()->delete();
                return ResponseHelper::success(
                    message: 'User Logged out Successfully !',
                    statusCode: 200);
            }
            return ResponseHelper::error(
                message: 'Unable log out ! due to invalid token ',
                statusCode: 400);

        } catch (Exception $e) {
            \Log::error('Unable To Logout Due to some exception :' . $e->getMessage() . ' - Line no. ' . $e->getLine());

            return ResponseHelper::error(
                message: 'Unable To Logout Due to some exception ! Please try again !' . $e->getMessage(),
                statusCode: 500);
        }
    }
}
