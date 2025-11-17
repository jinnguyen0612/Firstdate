<?php

namespace App\Admin\Http\Controllers\PartnerCategory;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\PartnerCategory\PartnerCategoryRequest;
use App\Admin\Repositories\PartnerCategory\PartnerCategoryRepositoryInterface;
use App\Admin\Services\PartnerCategory\PartnerCategoryServiceInterface;
use App\Admin\DataTables\PartnerCategory\PartnerCategoryDataTable;
use Illuminate\Http\RedirectResponse;


class PartnerCategoryController extends Controller
{
    public function __construct(
        PartnerCategoryRepositoryInterface $repository, 
        PartnerCategoryServiceInterface $service
    ){
        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(){
        return [
            'index' => 'admin.partner_categories.index',
            'create' => 'admin.partner_categories.create',
            'edit' => 'admin.partner_categories.edit'
        ];
    }

    public function getRoute(){
        return [
            'index' => 'admin.partner_category.index',
            'create' => 'admin.partner_category.create',
            'edit' => 'admin.partner_category.edit',
            'delete' => 'admin.partner_category.delete'
        ];
    }
    public function index(PartnerCategoryDataTable $dataTable){
		$isAdmin = auth('admin')->user()->hasRole('superAdmin');
        return $dataTable->render($this->view['index'],[
            'isAdmin' => $isAdmin,
            'breadcrumbs' => $this->crums->add(__('Danh sách Loại Đối tác'))
        ]);
    }

    public function create(){
        return view($this->view['create'],[
            'breadcrumbs' => $this->crums->add(
                __('Danh sách Loại Đối tác'),
                route($this->route['index'])
            )->add(__('Thêm mới Loại Đối tác')),
        ]);
    }

    public function store(PartnerCategoryRequest $request): RedirectResponse
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
                'category' => $response,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách Loại Đối tác'),
                    route($this->route['index'])
                )->add(__('Chỉnh sửa Loại Đối tác')),
            ]
        );

    }
 
    public function update(PartnerCategoryRequest $request): RedirectResponse
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