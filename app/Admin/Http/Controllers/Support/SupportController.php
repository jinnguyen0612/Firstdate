<?php

namespace App\Admin\Http\Controllers\Support;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Support\SupportRequest;
use App\Admin\Repositories\Support\SupportRepositoryInterface;
use App\Admin\Services\Support\SupportServiceInterface;
use App\Admin\DataTables\Support\SupportDataTable;
use App\Admin\Repositories\SupportCategory\SupportCategoryRepositoryInterface;
use Illuminate\Http\RedirectResponse;


class SupportController extends Controller
{
    public function __construct(
        SupportRepositoryInterface $repository,
        SupportServiceInterface $service,
        protected SupportCategoryRepositoryInterface $supportCategoryRepository,
    ) {
        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView()
    {
        return [
            'index' => 'admin.support.index',
            'create' => 'admin.support.create',
            'edit' => 'admin.support.edit'
        ];
    }

    public function getRoute()
    {
        return [
            'category' => 'admin.support_category.index',
            'index' => 'admin.support.index',
            'create' => 'admin.support.create',
            'edit' => 'admin.support.edit',
            'delete' => 'admin.support.delete'
        ];
    }
    public function index($support_category_id, SupportDataTable $dataTable)
    {
        $isAdmin = auth('admin')->user()->hasRole('superAdmin');

        $category = $this->supportCategoryRepository->findOrFail($support_category_id);

        return $dataTable->render($this->view['index'], [
            'isAdmin' => $isAdmin,
            'category' => $category,
            'breadcrumbs' => $this->crums->add(__('Danh sách Câu hỏi hỗ trợ'))
        ]);
    }

    public function create($support_category_id)
    {
        return view($this->view['create'], [
            'breadcrumbs' => $this->crums->add(
                __('Danh mục Câu hỏi hỗ trợ'),
                route($this->route['category'])
            )
                ->add(
                    __('Câu hỏi hỗ trợ'),
                    route($this->route['category'], $support_category_id)
                )->add(__('Thêm mới Câu hỏi hỗ trợ')),
            'category_id' => $support_category_id
        ]);
    }

    public function store(SupportRequest $request): RedirectResponse
    {
        return $this->handleStoreResponseWithOtherParam($request, function ($request) {
            return $this->service->store($request);
        }, $this->route['edit'], 'support_category_id', $request->support_category_id);
    }

    public function edit($support_category_id, $id)
    {
        $isAdmin = auth('admin')->user()->hasRole('superAdmin');
        $response = $this->repository->findOrFail($id);
        $category = $this->supportCategoryRepository->findOrFail($support_category_id);
        return view(
            $this->view['edit'],
            [
                'isAdmin' => $isAdmin,
                'category' => $response,
                'breadcrumbs' => $this->crums->add(
                    __('Danh mục Câu hỏi hỗ trợ'),
                    route($this->route['category'])
                )
                    ->add(
                        __('Danh sách Câu hỏi hỗ trợ'),
                        route($this->route['index'], $support_category_id)
                    )->add(__('Chỉnh sửa Câu hỏi hỗ trợ')),
            ]
        );
    }

    public function update(SupportRequest $request): RedirectResponse
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
