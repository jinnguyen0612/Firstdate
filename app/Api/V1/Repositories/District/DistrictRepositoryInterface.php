<?php

namespace App\Api\V1\Repositories\District;
use App\Admin\Repositories\EloquentRepositoryInterface;


interface DistrictRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByID($id);
    public function paginate($provinceId = 0, $page = 1, $limit = 10);
}