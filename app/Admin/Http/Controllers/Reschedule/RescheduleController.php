<?php

namespace App\Admin\Http\Controllers\Reschedule;

use App\Admin\DataTables\Reschedule\RescheduleDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Reschedule\RescheduleRequest;
use App\Admin\Repositories\Reschedule\RescheduleRepositoryInterface;
use App\Admin\Services\Reschedule\RescheduleServiceInterface;
use App\Admin\Traits\AuthService;
use App\Enums\Reschedule\RescheduleStatus;
use App\Enums\Reschedule\RescheduleType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RescheduleController extends Controller
{
    use AuthService;

    public function __construct(
        RescheduleRepositoryInterface $repository,
        RescheduleServiceInterface    $service
    ) {

        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
    }

    protected function getActionMultiple(): array
    {
        return [
            'approve' => __('Duyệt yêu cầu'),
            'reject' => __('Từ chối yêu cầu'),
        ];
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.reschedule.index',
            'create' => 'admin.reschedule.create',
            'edit' => 'admin.reschedule.edit',
            'show' => 'admin.reschedule.show',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.reschedule.index',
            'create' => 'admin.reschedule.create',
            'edit' => 'admin.reschedule.edit',
        ];
    }

    public function index(RescheduleDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('Danh sách yêu cầu đổi lịch')),
            'actionMultiple' => $this->getActionMultiple()
        ]);
    }

    public function create(): View|Application
    {
        return view($this->view['create'], [
            'breadcrumbs' => $this->crums->add(
                __('Danh sách yêu cầu đổi lịch'),
                route($this->route['index'])
            )->add(__('Thêm mới yêu cầu')),
        ]);
    }

    public function store(RescheduleRequest $request)
    {
        return $this->handleStoreResponse($request, function ($request) {
            return $this->service->store($request);
        }, $this->route['index']);
    }

    public function approve($id): RedirectResponse
    {
        $this->service->approve($id);
        return back()->with('success', __('notifySuccess'));
    }

    public function reject($id): RedirectResponse
    {
        $this->service->reject($id);
        return back()->with('success', __('notifySuccess'));
    }
}
