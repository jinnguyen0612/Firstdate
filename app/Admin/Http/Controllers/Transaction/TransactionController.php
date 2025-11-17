<?php

namespace App\Admin\Http\Controllers\Transaction;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Transaction\TransactionRequest;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Admin\DataTables\Transaction\TransactionDataTable;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Admin\Services\Transaction\TransactionServiceInterface;
use App\Enums\Transaction\TransactionStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(
        TransactionRepositoryInterface $repository,
        TransactionServiceInterface $service,
        private SettingRepositoryInterface $settingRepository,
    ){
        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(){
        return [
            'index' => 'admin.transaction.index',
            'create' => 'admin.transaction.create',
            'show' => 'admin.transaction.show'
        ];
    }

    public function getRoute(){
        return [
            'index' => 'admin.transaction.index',
            'create' => 'admin.transaction.create',
            'update' => 'admin.transaction.update',
        ];
    }
    public function index(TransactionDataTable $dataTable){

        return $dataTable->render($this->view['index'],[
            'breadcrumbs' => $this->crums->add(__('Danh sách giao dịch'))
        ]);
    }

    public function show($id){
        $settings = $this->settingRepository->getAll();
        $transaction = $this->repository->findOrFailWithRelation($id);
        $status = TransactionStatus::asSelectArray();
        $isAdmin = auth('admin')->user()->hasRole('superAdmin');
        return view(
            $this->view['show'],
            [
                'isAdmin' => $isAdmin,
                'settings' => $settings,
                'status' => $status,
                'transaction' => $transaction,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách giao dịch'),
                    route($this->route['index'])
                )->add(__('Chi tiết giao dịch')),
            ]
        );
    }

    public function update(TransactionRequest $request): RedirectResponse
    {
        return $this->handleUpdateResponse($request, function ($request) {
            return $this->service->update($request);
        });
    }
}
