<?php

namespace App\Admin\Http\Controllers\PriceList;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\PriceList\PriceListRequest;
use App\Admin\Repositories\PriceList\PriceListRepositoryInterface;
use App\Admin\Services\PriceList\PriceListServiceInterface;
use App\Admin\DataTables\PriceList\PriceListDataTable;
use Illuminate\Http\RedirectResponse;


class PriceListController extends Controller
{
    public function __construct(
        PriceListRepositoryInterface $repository, 
        PriceListServiceInterface $service
    ){
        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(){
        return [
            'index' => 'admin.price_list.index',
            'create' => 'admin.price_list.create',
            'edit' => 'admin.price_list.edit'
        ];
    }

    public function getRoute(){
        return [
            'index' => 'admin.price_list.index',
            'create' => 'admin.price_list.create',
            'edit' => 'admin.price_list.edit',
            'delete' => 'admin.price_list.delete'
        ];
    }
    public function index(PriceListDataTable $dataTable){
		$isAdmin = auth('admin')->user()->hasRole('superAdmin');
        return $dataTable->render($this->view['index'],[
            'isAdmin' => $isAdmin,
            'breadcrumbs' => $this->crums->add(__('Danh sách Giá nạp'))
        ]);
    }

    public function create(){
        $isAdmin = auth('admin')->user()->hasRole('superAdmin');
        return view($this->view['create'],[
            'breadcrumbs' => $this->crums->add(
                __('Danh sách Giá nạp'),
                route($this->route['index'])
            )->add(__('Thêm mới Giá nạp')),
            'isAdmin' => $isAdmin,
        ]);
    }

    public function store(PriceListRequest $request): RedirectResponse
    {
        return $this->handleStoreResponse($request, function ($request) {
            return $this->service->store($request);
        }, $this->route['edit']);
    }

    public function edit($id){
        $isAdmin = auth('admin')->user()->hasRole('superAdmin');
        $response = $this->repository->findOrFail($id);
        return view(
            $this->view['edit'],
            [
                'isAdmin' => $isAdmin,
                'priceList' => $response,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách Giá nạp'),
                    route($this->route['index'])
                )->add(__('Chỉnh sửa Giá nạp')),
            ]
        );

    }
 
    public function update(PriceListRequest $request): RedirectResponse
    {
        return $this->handleUpdateResponse($request, function ($request) {
            return $this->service->update($request);
        });
    }

    public function delete($id): RedirectResponse
    {
        return $this->handleDeleteResponse($id, function ($id) {
            return $this->service->delete($id);
        }, $this->route['index']);
    }
}