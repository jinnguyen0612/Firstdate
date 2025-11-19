<?php

namespace App\Admin\Http\Controllers\Package;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Package\PackageRequest;
use App\Admin\Repositories\Package\PackageRepositoryInterface;
use App\Admin\Services\Package\PackageServiceInterface;
use App\Admin\DataTables\Package\PackageDataTable;
use Illuminate\Http\RedirectResponse;


class PackageController extends Controller
{
    public function __construct(
        PackageRepositoryInterface $repository,
        PackageServiceInterface $service
    ){
        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(){
        return [
            'index' => 'admin.package.index',
            'create' => 'admin.package.create',
            'edit' => 'admin.package.edit'
        ];
    }

    public function getRoute(){
        return [
            'index' => 'admin.package.index',
            'create' => 'admin.package.create',
            'edit' => 'admin.package.edit',
            'delete' => 'admin.package.delete'
        ];
    }
    public function index(PackageDataTable $dataTable){
		$isAdmin = auth('admin')->user()->hasRole('superAdmin');
        return $dataTable->render($this->view['index'],[
            'isAdmin' => $isAdmin,
            'breadcrumbs' => $this->crums->add(__('Danh sách Gói'))
        ]);
    }

    public function create(){
        $isAdmin = auth('admin')->user()->hasRole('superAdmin');
        return view($this->view['create'],[
            'breadcrumbs' => $this->crums->add(
                __('Danh sách Gói'),
                route($this->route['index'])
            )->add(__('Thêm mới Gói')),
            'isAdmin' => $isAdmin,
        ]);
    }

    public function store(PackageRequest $request): RedirectResponse
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
                'package' => $response,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách Gói'),
                    route($this->route['index'])
                )->add(__('Chỉnh sửa Gói')),
            ]
        );

    }

    public function update(PackageRequest $request): RedirectResponse
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
