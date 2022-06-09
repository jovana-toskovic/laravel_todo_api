<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTodoListRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ListTaskResource;
use App\Http\Resources\ShortTaskResource;
use App\Http\Resources\TodoListResource;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListTaskController extends Controller
{
    public function __construct(protected TaskService $taskService)
    {
    }

    public function index(Request $request, $id, $listId): JsonResponse
    {
        $tasks = $this->taskService->findAllUserListTasks($id, $listId, $request->boolean('paginate'), 10);

        return response()->json(ListTaskResource::collection($tasks)->response()->getData(true));
    }
}
