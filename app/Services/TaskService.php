<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskService
{

    public function __construct(protected TaskRepositoryInterface $taskRepository)
    {
    }

    public function create(array $data): Task
    {
        return $this->taskRepository->create($data);
    }

    public function find(int $id): Task
    {
        return $this->taskRepository->find($id);
    }

    public function update(int $id, array $data): Task
    {
        return $this->taskRepository->update($id, $data);
    }

    public function findAllUserTasks($paginate, $perPage)
    {
        return $this->taskRepository->findAllUserTasks(auth()->user()->id, $paginate, $perPage);
    }

    public function delete(int $id): bool
    {
        return $this->taskRepository->delete($id);
    }

}
