<?php

namespace App\Admin\Services\Support;

use App\Admin\Services\Support\SupportServiceInterface;
use  App\Admin\Repositories\Support\SupportRepositoryInterface;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;

class SupportService implements SupportServiceInterface
{
    use Setup;
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(SupportRepositoryInterface $repository){
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
