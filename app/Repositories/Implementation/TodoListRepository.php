<?php

namespace App\Repositories\Implementation;


use App\Models\TodoList;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\TodoListRepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class TodoListRepository
 * @package App\Repositories\User
 */
class TodoListRepository extends BaseRepository implements TodoListRepositoryInterface
{
    /**
     * TodoListRepository constructor.
     * @param TodoList $model
     */
    public function __construct(TodoList $model)
    {
        parent::__construct($model);
    }

    public function findAllUserLists($id, $paginate, $perPage)
    {
        return QueryBuilder::for(TodoList::class)
            ->with(['tasks'])
            ->where('user_id', $id)
            ->allowedFilters('title', 'created_at')
            ->allowedSorts('title', 'created_at')
            ->paginate(10);
    }

    public function syncTasks($list, $tasks)
    {
        $list->tasks()->sync($tasks);
    }

}
