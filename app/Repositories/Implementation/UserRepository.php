<?php

namespace App\Repositories\Implementation;


use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;

/**
 * Class UserRepository
 * @package App\Repository\User
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * serRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

}
