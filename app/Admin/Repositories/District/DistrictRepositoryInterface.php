<?php

namespace App\Admin\Repositories\District;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface DistrictRepositoryInterface extends EloquentRepositoryInterface
{
    public function getById($id);
    public function getByName(string $name, $provinceCode);
}