<?php

namespace App\Services;

use App\Models\TodoList;
use App\Repositories\Interfaces\TodoListRepositoryInterface;
use Illuminate\Support\Collection;

class TodoListService
{

    public function __construct(protected TodoListRepositoryInterface $todoListRepository)
    {
    }

    /**
     * @param array $data
     * @param $tasks
     * @return TodoList
     */
    public function create(array $data, $tasks = null): TodoList
    {
        $list = $this->todoListRepository->create($data);

        if(is_array($tasks)) {
            $this->todoListRepository->syncTasks($list, $tasks);
        }

        return $list;
    }

    /**
     * @param $paginate
     * @param $sortBy
     * @param $order
     * @param $perPage
     * @param $filters
     * @return Collection
     */
    public function findAll($paginate = false, $sortBy = null, $order = 'asc', $perPage = 10, $filters = []): Collection
    {
        return $this->todoListRepository->findAll($paginate, $sortBy, $order, $perPage, $filters);
    }

    /**
     * @param int $id
     * @return TodoList
     */
    public function find(int $id): TodoList
    {
        return $this->todoListRepository->find($id);
    }

    /**
     * @param int $id
     * @param array $data
     * @param $tasks
     * @return TodoList
     */
    public function update(int $id, array $data, $tasks): TodoList
    {
        $list = $this->todoListRepository->update($id, $data);

        if(is_array($tasks)) {
            $this->todoListRepository->syncTasks($list, $tasks);
        }

        return $list;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->todoListRepository->delete($id);
    }

    /**
     * @param $paginate
     * @param $perPage
     * @param $listId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findAllUserTodoLists($paginate, $perPage, $listId)
    {
        return $this->todoListRepository->findAllUserLists(auth()->user()->id, $listId, $paginate, $perPage);
    }

}
