<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\ShortTaskResource;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService)
    {
    }

    public function index(Request $request, $id): JsonResponse
    {
        try{
            $tasks = $this->taskService->findAllUserTasks($id, $request->boolean('paginate'), 10);
            return response()->json(ShortTaskResource::collection($tasks)->response()->getData(true));
        } catch (\Exception $exception) {
            return response()->json(['error_message' => $exception->getMessage()], 404);
        }
    }

    public function show($taskId): JsonResponse
    {
        try{
            $task = $this->taskService->find($taskId);
            return response()->json(new ShortTaskResource($task));
        } catch (\Exception $exception) {
            return response()->json(['error_message' => $exception->getMessage()], 404);
        }
    }

    public function store(StoreTaskRequest $request, $id): JsonResponse
    {
        try{
            $data = $request->except(['tasks']);
            $data['user_id'] = $id;
            $list = $this->taskService->create($data);
            return response()->json(new ShortTaskResource($list));
        } catch (\Exception $exception) {
            return response()->json(['error_message' => $exception->getMessage()], 404);
        }
    }

    public function update(UpdateTaskRequest $request, $id, $taskId): JsonResponse
    {
        try{
            $data = $request->all();
            $data['user_id'] = $id;
            $task = $this->taskService->update($taskId, $data);
            return response()->json(new ShortTaskResource($task));
        } catch (\Exception $exception) {
            return response()->json(['error_message' => $exception->getMessage()],  404);
        }
    }

    public function delete($id, $taskId): JsonResponse
    {
        try{
            $this->taskService->delete($taskId);
            return response()->json([], 204);
        } catch (\Exception $exception) {
            return response()->json(['error_message' => $exception->getMessage()],  404);
        }
    }
}
