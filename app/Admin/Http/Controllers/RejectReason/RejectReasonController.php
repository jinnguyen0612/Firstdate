<?php

namespace App\Admin\Http\Controllers\RejectReason;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\RejectReason\RejectReasonRequest;
use App\Admin\Repositories\RejectReason\RejectReasonRepositoryInterface;
use App\Admin\Services\RejectReason\RejectReasonServiceInterface;
use App\Admin\Support\Breadcrumb\Breadcrumb;
use App\Traits\ResponseController;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RejectReasonController extends Controller
{

    public function __construct(
        RejectReasonRepositoryInterface $repository,
        RejectReasonServiceInterface $service
    ) {
        parent::__construct();
        $this->crums = (new Breadcrumb())->add(__('Dashboard'), route('admin.dashboard'));
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.reject_reason.index',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.reject_reason.index',
            'update' => 'admin.reject_reason.update',
        ];
    }

    public function index(): Factory|View|Application
    {
        $reasons = $this->repository->getQueryBuilderOrderBy()->get();
        $isAdmin = auth('admin')->user()->hasRole('superAdmin');
        return view($this->view['index'], [
            'reasons' => $reasons,
            'isAdmin' => $isAdmin,
            'breadcrumbs' => $this->crums->add(__('QL Lý do từ chối')),
        ]);
    }

    public function update(RejectReasonRequest $request): RedirectResponse
    {
        return $this->handleUpdateResponse($request, function ($request) {
            return $this->service->update($request);
        });
    }
}
