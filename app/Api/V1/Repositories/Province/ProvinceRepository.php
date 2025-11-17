<?php

namespace App\Api\V1\Repositories\Province;
use App\Admin\Repositories\Province\ProvinceRepository as AdminProvinceRepository;
use App\Api\V1\Repositories\Province\ProvinceRepositoryInterface;
use App\Models\Province;

class ProvinceRepository extends AdminProvinceRepository implements ProvinceRepositoryInterface
{
    public function getModel(){
        return Province::class;
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
    public function paginate($page = 1, $limit = 10)
    {
        $page = $page ? $page - 1 : 0;
        $this->instance = $this->model
        ->offset($page * $limit)
        ->limit($limit)
        ->orderBy('id', 'asc')
        ->get();
        return $this->instance;
    }
    public function getAllOrderBy($field = 'id', $order = 'asc'){
        $this->instance = $this->model
        ->orderBy($field,$order)
        ->get();
        return $this->instance;
    }
	
}