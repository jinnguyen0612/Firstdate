<?php

namespace App\Admin\Http\Controllers\User;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Services\User\UserServiceInterface;
use App\Admin\DataTables\User\UserDataTable;
use App\Admin\Http\Requests\User\UserRequest;
use App\Admin\Repositories\District\DistrictRepositoryInterface;
use App\Admin\Repositories\Province\ProvinceRepositoryInterface;
use App\Admin\Traits\AuthService;
use App\Enums\User\DatingTime;
use App\Enums\User\Gender;
use App\Enums\User\LookingFor;
use App\Enums\User\Relationship;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Exception;


class UserController extends Controller
{
    use AuthService;

    public function __construct(
        UserRepositoryInterface $repository,
        UserServiceInterface    $service,
        protected DistrictRepositoryInterface $districtRepository,
        protected ProvinceRepositoryInterface $provinceRepository,
    ) {
        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'edit' => 'admin.users.edit'
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.user.index',
            'create' => 'admin.user.create',
            'edit' => 'admin.user.edit',
            'delete' => 'admin.user.delete',
            'confirm' => 'admin.user.confirm',
            'disable' => 'admin.user.disable'
        ];
    }

    public function index(UserDataTable $dataTable)
    {
        $isAdmin = auth('admin')->user()->hasRole('superAdmin');
        return $dataTable->render($this->view['index'], [
            'isAdmin' => $isAdmin,
            'gender' => Gender::asSelectArray(),
            'breadcrumbs' => $this->crums->add(__('Danh sách khách hàng'))
        ]);
    }

    public function create(): Factory|View|Application
    {
        return view($this->view['create'], [
            'gender' => Gender::asSelectArray(),
            'lookingFor' => LookingFor::asSelectArray(),
            'datingTime' => DatingTime::asSelectArray(),
            'relationships' => Relationship::asSelectArray(),
            'breadcrumbs' => $this->crums->add(
                __('Danh sách người dùng'),
                route($this->route['index'])
            )->add(__('Thêm mới người dùng')),
        ]);
    }

    public function edit($id): Factory|View|Application
    {
        $isAdmin = auth('admin')->user()->hasRole('superAdmin');
        $instance = $this->repository->findOrFailWithRelation($id);
        if (isset($instance['province_id'])) {
            $province = $this->provinceRepository->getById($instance['province_id']);
            $instance['province'] = $province->name;
        }
        if (isset($instance['district_id'])) {
            $district =  $this->districtRepository->getById($instance['district_id']);
            $instance['district'] = $district->name;
        }
        return view(
            $this->view['edit'],
            [
                'isAdmin' => $isAdmin,
                'user' => $instance,
                'lookingFor' => LookingFor::asSelectArray(),
                'datingTime' => DatingTime::asSelectArray(),
                'relationships' => Relationship::asSelectArray(),
                'gender' => Gender::asSelectArray(),
                'age' => Carbon::parse($instance->birthday)->age,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách người dùng'),
                    route($this->route['index'])
                )->add(__('Chỉnh sửa người dùng')),
            ],
        );
    }

    public function store(UserRequest $request): RedirectResponse
    {
        return $this->handleStoreResponse($request, function ($request) {
            return $this->service->store($request);
        }, $this->route['edit']);
    }

    public function update(UserRequest $request): RedirectResponse
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
