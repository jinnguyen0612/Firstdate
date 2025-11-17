<?php

namespace App\Admin\Services\SupportCategory;

use App\Admin\Services\SupportCategory\SupportCategoryServiceInterface;
use  App\Admin\Repositories\SupportCategory\SupportCategoryRepositoryInterface;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;

class SupportCategoryService implements SupportCategoryServiceInterface
{
    use Setup;
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(SupportCategoryRepositoryInterface $repository){
        $this->repository = $repository;
    }

    public function store(Request $request){
        $this->data = $request->validated();
        return $this->repository->create($this->data);
    }

    public function update(Request $request){
        $this->data = $request->validated();
        return $this->repository->update($this->data['id'], $this->data);
    }

    public function delete($id){
        return $this->repository->delete($id);

    }

}
