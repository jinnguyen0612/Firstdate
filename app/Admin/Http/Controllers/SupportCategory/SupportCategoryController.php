<?php

namespace App\Admin\Http\Controllers\SupportCategory;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\SupportCategory\SupportCategoryRequest;
use App\Admin\Repositories\SupportCategory\SupportCategoryRepositoryInterface;
use App\Admin\Services\SupportCategory\SupportCategoryServiceInterface;
use App\Admin\DataTables\SupportCategory\SupportCategoryDataTable;
use Illuminate\Http\RedirectResponse;


class SupportCategoryController extends Controller
{
    public function __construct(
        SupportCategoryRepositoryInterface $repository,
        SupportCategoryServiceInterface $service
    ){
        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(){
        return [
            'index' => 'admin.support_category.index',
            'create' => 'admin.support_category.create',
            'edit' => 'admin.support_category.edit'
        ];
    }

    public function getRoute(){
        return [
            'index' => 'admin.support_category.index',
            'create' => 'admin.support_category.create',
            'edit' => 'admin.support_category.edit',
            'delete' => 'admin.support_category.delete'
        ];
    }
    public function index(SupportCategoryDataTable $dataTable){
		$isAdmin = auth('admin')->user()->hasRole('superAdmin');
        return $dataTable->render($this->view['index'],[
            'isAdmin' => $isAdmin,
            'breadcrumbs' => $this->crums->add(__('Danh sách Danh mục Câu hỏi hỗ trợ'))
        ]);
    }

    public function create(){
        return view($this->view['create'],[
            'breadcrumbs' => $this->crums->add(
                __('Danh sách Danh mục Câu hỏi hỗ trợ'),
                route($this->route['index'])
            )->add(__('Thêm mới Danh mục Câu hỏi hỗ trợ')),
        ]);
    }

    public function store(SupportCategoryRequest $request): RedirectResponse
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
                    __('Danh sách Danh mục Câu hỏi hỗ trợ'),
                    route($this->route['index'])
                )->add(__('Chỉnh sửa Danh mục Câu hỏi hỗ trợ')),
            ]
        );

    }

    public function update(SupportCategoryRequest $request): RedirectResponse
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
