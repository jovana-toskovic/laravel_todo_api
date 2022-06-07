<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTodoListRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TodoListResource;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $tasks = $this->taskService->findAllUserTasks($request->boolean('paginate'), 10);
        return response()->json(TaskResource::collection($tasks)->response()->getData(true));
    }

    public function show($taskId): JsonResponse
    {
        $task = $this->taskService->find($taskId);
        return response()->json(new TaskResource($task));
    }

    public function store(StoreTodoListRequest $request, $id): JsonResponse
    {
        try{
            $data = $request->except(['tasks']);
            $data['user_id'] = $id;
            $list = $this->taskService->create($data, $request->tasks);
            return response()->json(new TodoListResource($list));
        } catch (\Exception $exception) {
            return response()->json(['error_message' => $exception->getMessage()], 404);
        }

    }

    public function update(UpdateUserRequest $request, $id, $taskId): JsonResponse
    {
        $data = $request->all();
        $data['user_id'] = $id;
        $task = $this->taskService->update($taskId, $data);
        return response()->json(new TaskResource($task));
    }

    public function delete($taskId): JsonResponse
    {
        $this->taskService->delete($taskId);
        return response()->json([], 204);
    }
}
