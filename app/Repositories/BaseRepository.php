<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
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

}
