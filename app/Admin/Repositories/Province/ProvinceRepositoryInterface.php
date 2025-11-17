<?php

namespace App\Admin\Repositories\Province;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface ProvinceRepositoryInterface extends EloquentRepositoryInterface
{
    public function getById($id);
    public function getByName(string $name);
}