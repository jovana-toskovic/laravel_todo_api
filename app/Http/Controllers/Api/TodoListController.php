<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTodoListRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\TodoListResource;
use App\Services\TodoListService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    public function __construct(protected TodoListService $todoListService)
    {
    }

    public function index(Request $request, $id, $listId): JsonResponse
    {
        try{
            $lists = $this->todoListService->findAllUserTodoLists($request->boolean('paginate'), 10, $listId);
            return response()->json(TodoListResource::collection($lists)->response()->getData(true));
        } catch (\Exception $exception) {
            return response()->json(['error_message' => $exception->getMessage()],404);
        }
    }

    public function show($listId): JsonResponse
    {
        try{
            $list = $this->todoListService->find($listId);
            return response()->json(new TodoListResource($list));
        } catch (\Exception $exception) {
            return response()->json(['error_message' => $exception->getMessage()],404);
        }
    }

    public function store(StoreTodoListRequest $request, $id): JsonResponse
    {
        try{
            $data = $request->except(['tasks']);
            $data['user_id'] = $id;
            $list = $this->todoListService->create($data, $request->tasks);
            return response()->json(new TodoListResource($list));
        } catch (\Exception $exception) {
            return response()->json(['error_message' => $exception->getMessage()],404);
        }

    }

    public function update(UpdateUserRequest $request, $id, $listId): JsonResponse
    {
        try{
            $data = $request->except(['tasks']);
            $data['user_id'] = $id;
            $list = $this->todoListService->update($listId, $data, $request->tasks);
        return response()->json(new TodoListResource($list));
        } catch (\Exception $exception) {
            return response()->json(['error_message' => $exception->getMessage()],404);
        }
    }

    public function delete($id, $listId): JsonResponse
    {
        try{
            $this->todoListService->delete($listId);
            return response()->json([], 204);
        } catch (\Exception $exception) {
            return response()->json(['error_message' => $exception->getMessage()],404);
        }
    }
}
