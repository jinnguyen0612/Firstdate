<?php

namespace App\Admin\Repositories\District;
use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\District\DistrictRepositoryInterface;
use App\Models\District;
use App\Models\Module;

class DistrictRepository extends EloquentRepository implements DistrictRepositoryInterface
{

    protected $select = [];

    public function getModel(){
        return District::class;
    }


    public function getById($id)
    {
        $record = $this->findOrFail($id);
        return $record ?? null;
    }

    public function getByName(string $name, $provinceCode)
    {
        $record = $this->model->where('province_code', $provinceCode)->where('name','like', '%' . $name . '%')->firstOrFail();
        return $record;
    }


}