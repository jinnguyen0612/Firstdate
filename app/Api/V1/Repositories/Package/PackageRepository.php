<?php

namespace App\Api\V1\Repositories\Package;

use App\Admin\Repositories\Package\PackageRepository as AdminPackageRepository;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageRepository extends AdminPackageRepository implements PackageRepositoryInterface
{
    protected $model;

    public function __construct(Package $model)
    {
        $this->model = $model;
    }

    public function get()
    {
        return $this->model->get();
    }

    public function detail($id)
    {
        return $this->model->detail($id);
    }

    public function paginate($limit = 10)
    {
        $this->instance = $this->model
            ->where('is_active', 1)
            ->orderBy('id', 'desc')
            ->paginate($limit);
        return $this->instance;
    }
}
