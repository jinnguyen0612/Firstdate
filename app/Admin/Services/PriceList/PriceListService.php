<?php

namespace App\Admin\Services\PriceList;

use App\Admin\Services\PriceList\PriceListServiceInterface;
use  App\Admin\Repositories\PriceList\PriceListRepositoryInterface;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;

class PriceListService implements PriceListServiceInterface
{
    use Setup;
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;
    
    protected $repository;

    public function __construct(PriceListRepositoryInterface $repository){
        $this->repository = $repository;
    }
    
    public function store(Request $request){
        $this->data = $request->validated();
        $this->data['price'] = str_replace(',', '', trim($this->data['price']));
        return $this->repository->create($this->data);
    }

    public function update(Request $request){
        $this->data = $request->validated();
        $this->data['price'] = str_replace(',', '', trim($this->data['price']));
        return $this->repository->update($this->data['id'], $this->data);
    }

    public function delete($id){
        return $this->repository->delete($id);

    }

}