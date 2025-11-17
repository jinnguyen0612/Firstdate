<?php

namespace App\Admin\Http\Controllers\Slider;

use App\Admin\Http\Controllers\Controller;
use App\Admin\DataTables\Slider\SliderItemDataTable;
use App\Admin\Repositories\Slider\{SliderRepositoryInterface, SliderItemRepositoryInterface};
use App\Admin\Services\Slider\SliderItemServiceInterface;
use App\Admin\Http\Requests\Slider\SliderItemRequest;

class SliderItemController extends Controller
{
    protected $repositorySlider;
    public function __construct(
        SliderItemRepositoryInterface $repository,
        SliderRepositoryInterface $repositorySlider,
        SliderItemServiceInterface $service
    ) {
        parent::__construct();
        $this->repository = $repository;
        $this->repositorySlider = $repositorySlider;
        $this->service = $service;
    }
    public function getView()
    {
        return [
            'index' => 'admin.sliders.items.index',
            'create' => 'admin.sliders.items.create',
            'edit' => 'admin.sliders.items.edit',
        ];
    }

    public function getRoute()
    {
        return [
            'index' => 'admin.slider.item.index',
            'create' => 'admin.slider.item.create',
            'edit' => 'admin.slider.item.edit',
            'delete' => 'admin.slider.item.delete',
            'slider' => 'admin.slider.index',
        ];
    }
    public function index($slider_id, SliderItemDataTable $dataTable)
    {
        $slider = $this->repositorySlider->findOrFail($slider_id);
        return $dataTable->with('slider', $slider)->render($this->view['index'], [
            'slider' => $slider,
            'breadcrumbs' => $this->crums->add(
                __('Slider'),
                route($this->route['slider'])
            )->add(__('Danh sách Slider item'), route($this->route['index'], $slider_id)),
        ]);
    }

    public function create($slider_id)
    {
        $slider = $this->repositorySlider->findOrFail($slider_id);
        return view($this->view['create'], [
            'breadcrumbs' => $this->crums->add(
                __('Danh sách Slider item'),
                route($this->route['index'], $slider_id)
            )->add(__('Thêm Slider item')),
        ], compact('slider'));
    }

    public function store(SliderItemRequest $request)
    {
        return $this->handleStoreResponse($request, function ($request) {
            return $this->service->store($request);
        }, $this->route['edit']);
    }

    public function edit($id)
    {
        $sliderItem = $this->repository->findOrFailWithRelations($id);
        return view($this->view['edit'], [
            'breadcrumbs' => $this->crums->add(
                __('Danh sách Slider item'),
                route($this->route['index'], $sliderItem->slider->id)
            )->add(__('Sửa Slider item')),
        ], compact('sliderItem'));
    }

    public function update(SliderItemRequest $request)
    {
        return $this->handleUpdateResponse($request, function ($request) {
            return $this->service->update($request);
        });
    }

    public function delete($slider_id, $id)
    {
        return $this->handleDeleteResponseWithCustomParam($id,  function ($id) {
            return $this->service->delete($id);
        }, $this->route['index'], $slider_id);
    }
}
