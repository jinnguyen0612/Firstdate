<?php

namespace App\Admin\Http\Controllers\Partner;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Partner\PartnerRequest;
use App\Admin\Repositories\Partner\PartnerRepositoryInterface;
use App\Admin\Services\Partner\PartnerServiceInterface;
use App\Admin\Repositories\Province\ProvinceRepositoryInterface;
use App\Admin\Repositories\District\DistrictRepositoryInterface;
use App\Admin\DataTables\Partner\PartnerDataTable;
use App\Enums\User\Gender;
use Illuminate\Http\RedirectResponse;


class PartnerController extends Controller
{
    public function __construct(
        PartnerRepositoryInterface $repository, 
        PartnerServiceInterface $service,
        protected ProvinceRepositoryInterface $provinceRepository,
        protected DistrictRepositoryInterface $districtRepository
    ){
        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(){
        return [
            'index' => 'admin.partners.index',
            'create' => 'admin.partners.create',
            'edit' => 'admin.partners.edit'
        ];
    }

    public function getRoute(){
        return [
            'index' => 'admin.partner.index',
            'create' => 'admin.partner.create',
            'edit' => 'admin.partner.edit',
            'delete' => 'admin.partner.delete'
        ];
    }
    public function index(PartnerDataTable $dataTable){
		$isAdmin = auth('admin')->user()->hasRole('superAdmin');

        return $dataTable->render($this->view['index'],[
            'isAdmin' => $isAdmin,
            'breadcrumbs' => $this->crums->add(__('Danh sách Đối tác'))
        ]);
    }

    public function create(){
        return view($this->view['create'],[
            'breadcrumbs' => $this->crums->add(
                __('Danh sách Đối tác'),
                route($this->route['index'])
            )->add(__('Thêm mới Đối tác')),
        ]);
    }

    public function store(PartnerRequest $request): RedirectResponse
    {
        return $this->handleStoreResponse($request, function ($request) {
            return $this->service->store($request);
        }, $this->route['edit']);
    }

    public function edit($id){
        $isAdmin = auth('admin')->user()->hasRole('superAdmin');
        $response = $this->repository->findOrFail($id);

        $province = $this->provinceRepository->getById($response['province_id']);
        $response['province'] = $province->name;
        
        $district = $this->districtRepository->getById($response['district_id']);
        $response['district'] = $district->name;

        return view(
            $this->view['edit'],
            [
                'isAdmin' => $isAdmin,
                'user' => $response,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách Đối tác'),
                    route($this->route['index'])
                )->add(__('Chỉnh sửa Đối tác')),
            ]
        );

    }
 
    public function update(PartnerRequest $request): RedirectResponse
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