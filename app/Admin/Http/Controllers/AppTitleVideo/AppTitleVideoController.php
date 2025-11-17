<?php

namespace App\Admin\Http\Controllers\AppTitleVideo;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\AppTitleVideo\AppTitleVideoRequest;
use App\Admin\Repositories\AppTitleVideo\AppTitleVideoRepositoryInterface;
use App\Admin\Services\AppTitleVideo\AppTitleVideoServiceInterface;
use App\Admin\Support\Breadcrumb\Breadcrumb;
use App\Traits\ResponseController;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AppTitleVideoController extends Controller
{

    public function __construct(
        AppTitleVideoRepositoryInterface $repository,
        AppTitleVideoServiceInterface $service
    ) {
        parent::__construct();
        $this->crums = (new Breadcrumb())->add(__('Dashboard'), route('admin.dashboard'));
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.app_title_video.index',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.app_title_video.index',
            'update' => 'admin.app_title_video.update',
        ];
    }

    public function index(): Factory|View|Application
    {
        $titles = $this->repository->getQueryBuilderOrderBy('id','ASC')->get();

        return view($this->view['index'], [
            'titles' => $titles,
            'breadcrumbs' => $this->crums->add(__('QL Video hiển thị')),
        ]);
    }

    public function update(AppTitleVideoRequest $request): RedirectResponse
    {
        $this->service->update($request);
        return redirect()->back()->with('success', __('Cập nhật thành công!'));
    }
}
