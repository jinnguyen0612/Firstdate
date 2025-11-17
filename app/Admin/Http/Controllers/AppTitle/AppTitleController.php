<?php

namespace App\Admin\Http\Controllers\AppTitle;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\AppTitle\AppTitleRequest;
use App\Admin\Repositories\AppTitle\AppTitleRepositoryInterface;
use App\Admin\Services\AppTitle\AppTitleServiceInterface;
use App\Admin\Support\Breadcrumb\Breadcrumb;
use App\Traits\ResponseController;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AppTitleController extends Controller
{

    public function __construct(
        AppTitleRepositoryInterface $repository,
        AppTitleServiceInterface $service
    ) {
        parent::__construct();
        $this->crums = (new Breadcrumb())->add(__('Dashboard'), route('admin.dashboard'));
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.app_title.index',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.app_title.index',
            'update' => 'admin.app_title.update',
        ];
    }

    public function index(): Factory|View|Application
    {
        $titles = $this->repository->getQueryBuilderOrderBy('id','ASC')->get();

        return view($this->view['index'], [
            'titles' => $titles,
            'breadcrumbs' => $this->crums->add(__('QL Tiêu đề hiển thị')),
        ]);
    }

    public function update(AppTitleRequest $request): RedirectResponse
    {
        $this->service->update($request);
        return redirect()->back()->with('success', __('Cập nhật thành công!'));
    }
}