<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error_message' => 'Incorrect Details. Please try again'],  403);
        }

        $user = auth()->user();

        $token = $user->createToken('API Token')->accessToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }



}
