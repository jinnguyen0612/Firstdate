<?php

namespace App\Admin\Http\Controllers\PartnerTable;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\PartnerTable\PartnerTableRequest;
use App\Admin\Repositories\PartnerTable\PartnerTableRepositoryInterface;
use App\Admin\Services\PartnerTable\PartnerTableServiceInterface;
use App\Admin\DataTables\PartnerTable\PartnerTableDataTable;
use App\Admin\Repositories\Partner\PartnerRepositoryInterface;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Exceptions\CustomException;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PartnerTableController extends Controller
{
    public function __construct(
        PartnerTableRepositoryInterface $repository,
        PartnerTableServiceInterface $service,
        protected PartnerRepositoryInterface $partnerRepository,
        protected SettingRepositoryInterface $settingRepository,
    ) {
        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView()
    {
        return [
            'index' => 'admin.partner_table.index',
            'create' => 'admin.partner_table.create',
            'edit' => 'admin.partner_table.edit'
        ];
    }

    public function getRoute()
    {
        return [
            'partner' => 'admin.partner.edit',
            'index' => 'admin.partner.table.index',
            'create' => 'admin.partner.table.create',
            'edit' => 'admin.partner.table.edit',
            'delete' => 'admin.partner.table.delete'
        ];
    }
    public function index($partner_id, PartnerTableDataTable $dataTable)
    {
        $logo = $this->settingRepository->getQueryBuilder()->where('setting_key', 'favicon')->first()->plain_value;
        $isAdmin = auth('admin')->user()->hasRole('superAdmin');
        $partner = $this->partnerRepository->findOrFail($partner_id);

        return $dataTable->render($this->view['index'], [
            'logo' => $logo,
            'isAdmin' => $isAdmin,
            'partner' => $partner,
            'breadcrumbs' => $this->crums->add(
                __('Đối tác'),
                route($this->route['partner'], $partner->id)
            )->add(__('Danh sách Bàn'))
        ]);
    }

    public function create($partner_id)
    {
        $partner = $this->partnerRepository->findOrFail($partner_id);
        return view($this->view['create'], [
            'breadcrumbs' => $this->crums
                ->add(
                    __('Đối tác'),
                    route($this->route['partner'], $partner->id)
                )
                ->add(
                    __('Danh sách Bàn'),
                    route($this->route['index'], $partner_id)
                )->add(__('Thêm mới Bàn')),
            'partner' => $partner,
        ]);
    }

    public function store(PartnerTableRequest $request): RedirectResponse
    {
        return $this->handleStoreResponse($request, function ($request) {
            return $this->service->store($request);
        }, $this->route['edit']);
    }

    public function edit($id)
    {
        $isAdmin = auth('admin')->user()->hasRole('superAdmin');
        $response = $this->repository->findOrFail($id);
        $partner = $this->partnerRepository->findOrFail($response->partner_id);
        return view(
            $this->view['edit'],
            [
                'isAdmin' => $isAdmin,
                'instance' => $response,
                'partner' => $partner,
                'breadcrumbs' => $this->crums
                    ->add(
                        __('Đối tác'),
                        route($this->route['partner'], $partner->id)
                    )
                    ->add(
                        __('Danh sách Bàn'),
                        route($this->route['index'], $partner->id)
                    )->add(__('Chỉnh sửa Bàn')),
            ]
        );
    }

    public function update(PartnerTableRequest $request): RedirectResponse
    {
        return $this->handleUpdateResponse($request, function ($request) {
            return $this->service->update($request);
        });
    }

    public function delete($id): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $partner_id = $this->repository->findOrFail($id)->partner_id;
            $response = $this->service->delete($id);;

            if ($response) {
                DB::commit();
                return to_route($this->route['index'], ['partner_id' => $partner_id])->with('success', __('notifySuccess'));
            }

            DB::rollback();
            return back()->with('error', __('notifyFail'));
        } catch (CustomException $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        } catch (Exception $e) {
            DB::rollback();
            $this->logError("Error during delete operation", $e);
            return back()->with('error', __('notifyFail'));
        }
    }
}
