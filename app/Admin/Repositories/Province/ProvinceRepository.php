<?php

namespace App\Admin\Repositories\Province;
use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Province\ProvinceRepositoryInterface;
use App\Models\Province;
use App\Models\Module;

class ProvinceRepository extends EloquentRepository implements ProvinceRepositoryInterface
{

    protected $select = [];

    public function getModel(){
        return Province::class;
    }


    public function getById($id)
    {
        $record = $this->findOrFail($id);
        return $record ?? null;
    }

    public function getByName(string $name)
    {
        $record = $this->model->where('name','like', '%' . $name . '%')->firstOrFail();
        return $record;
    }


}