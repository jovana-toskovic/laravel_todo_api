<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    /**
     * @param UpdateUserRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, $id): JsonResponse
    {

        try {
            $user = $this->userService->update($id, $request->only('timezone'));
            return response()->json(['user' => new UserResource($user)]);
        } catch (\Exception $exception) {
            return response()->json(['error_message' => $exception->getMessage()],  404);
        }

    }
}
