<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class BaseRepository implements BaseRepositoryInterface
{

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(protected Model $model)
    {
    }

    /**
     * @return Collection
     */
    public function findAll($paginate = false, $sortBy = null, $order = 'asc', $perPage = 10, $filters = [])
    {
        $query = $this->model;

        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                $query = $query->where($key, $value);
            }
        }

        if ($sortBy) {
            $query = $query->orderBy($sortBy, $order);
        }

        return $paginate ? $query->paginate($perPage) : $query->get();
    }

    public function findAllByCriteria($criteria = [], $paginate = false, $sortBy = null, $order = 'asc', $perPage = 10, $filters = [])
    {
        $query = $this->model;

        if (!empty($criteria)) {
            foreach ($criteria as $key => $value) {
                $query = $query->where($key, $value);
            }
        }

        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                $query = $query->where($key, $value);
            }
        }

        if ($sortBy) {
            $query->orderBy($sortBy, $order);
        }

        return $paginate ? $query->paginate($perPage) : $query->get();
    }


    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model
    {
        $model = $this->find($id);

        if ($model) {
            foreach ($data as $property => $value) {
                $model->{$property} = $value;
            }
        }

        $model->save();

        return $model;
    }

    /**
     * @param int $id
     * @return Model
     */
    public function find(int $id): Model
    {
        $model = $this->model->find($id);

        if (!$model) {
            throw new NotFoundResourceException(class_basename($this->model) . " with id $id not found");
        }

        return $model;
    }


    /**
     * @param $id
     * @return bool|null
     */
    public function delete($id)
    {
        $model = $this->find($id);

        if ($model) {
            return $model->delete();
        }

        return false;

    }
}
