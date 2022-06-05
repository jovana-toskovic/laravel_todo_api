<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface BaseRepositoryInterface
 * @package App\Repository
 */
interface BaseRepositoryInterface
{
    /**
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model;

    /**
     * @param int $id
     * @return Model
     */
    public function find(int $id): Model;
}
