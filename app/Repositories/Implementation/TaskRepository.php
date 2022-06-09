<?php

namespace App\Repositories\Implementation;


use App\Models\ListTask;
use App\Models\Task;
use App\Models\TodoList;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class TaskRepository
 * @package App\Repositories\Task
 */
class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    /**
     * TaskRepository constructor.
     * @param Task $model
     */
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }

    public function findAllUserListTasks($id, $listId, $paginate, $perPage): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return QueryBuilder::for(ListTask::class)
            ->with(['task' => function($query) use ($id) {
                $query->where('user_id', $id);
            }])
            ->where('list_id', $listId)
            ->allowedFilters('title', 'done', 'deadline')
            ->allowedSorts('title', 'done', 'deadline')
            ->paginate(10);
    }

    public function findAllUserTasks($userId, $paginate, $perPage): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return QueryBuilder::for(Task::class)
            ->with(['user'])
            ->where('user_id', $userId)
            ->allowedFilters('title')
            ->allowedSorts('title')
            ->paginate(10);
    }



}
