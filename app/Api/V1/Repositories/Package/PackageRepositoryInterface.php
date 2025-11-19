<?php

namespace App\Api\V1\Repositories\Package;

use App\Admin\Repositories\EloquentRepositoryInterface;
use App\Admin\Repositories\Package\PackageRepositoryInterface as AdminPackageRepositoryInterface;
use Illuminate\Http\Request;

interface PackageRepositoryInterface extends AdminPackageRepositoryInterface
{
    public function getAll();
    public function paginate($limit = 10);
}
