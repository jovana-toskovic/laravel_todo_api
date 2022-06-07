<?php

namespace App\Repositories\Implementation;


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

    public function findAllUserTasks($id, $listId, $paginate, $perPage)
    {
        return QueryBuilder::for(Task::class)
            ->with(['user', 'lists' =>  function($query) use ($listId) { $query->where('list_id', $listId);}])
            ->where('user_id', $id)
            ->allowedFilters('title', 'done', 'deadline')
            ->allowedSorts('title', 'done', 'deadline')
            ->paginate(10);
    }

}
