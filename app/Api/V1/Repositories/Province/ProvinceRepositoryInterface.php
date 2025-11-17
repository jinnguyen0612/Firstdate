<?php

namespace App\Api\V1\Repositories\Province;
use App\Admin\Repositories\EloquentRepositoryInterface;


interface ProvinceRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByID($id);
    public function paginate($page = 1, $limit = 10);
}