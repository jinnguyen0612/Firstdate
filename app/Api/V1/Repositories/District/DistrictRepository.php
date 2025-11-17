<?php

namespace App\Api\V1\Repositories\District;
use App\Admin\Repositories\District\DistrictRepository as AdminDistrictRepository;
use App\Api\V1\Repositories\District\DistrictRepositoryInterface;
use App\Models\District;
use App\Models\Province;

class DistrictRepository extends AdminDistrictRepository implements DistrictRepositoryInterface
{
    public function getModel(){
        return District::class;
    }
	
    public function findByID($id)
    {
        $this->instance = $this->model->where('id', $id)
        ->firstOrFail();
		
        if ($this->instance && $this->instance->exists()) {
			return $this->instance;
		}

		return null;
    }
    public function paginate($provinceId = 0, $page = 1, $limit = 10)
    {
        $page = $page ? $page - 1 : 0;
        $province = Province::find($provinceId);
        $this->instance = $this->model->where('province_code', $province->code)
        ->offset($page * $limit)
        ->limit($limit)
        ->orderBy('id', 'asc')
        ->get();
        return $this->instance;
    }
	public function getDistrictByProvince($provinceId){
        $province = Province::find($provinceId);
        $this->instance = $this->model->where('province_code', $province->code)
        ->orderBy('id', 'asc')
        ->get();
        return $this->instance;
    }
}