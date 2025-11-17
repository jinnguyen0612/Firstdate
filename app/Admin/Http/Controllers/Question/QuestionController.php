<?php

namespace App\Admin\Http\Controllers\Question;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Question\QuestionRequest;
use App\Admin\Repositories\Question\QuestionRepositoryInterface;
use App\Admin\Services\Question\QuestionServiceInterface;
use App\Admin\DataTables\Question\QuestionDataTable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct(
        QuestionRepositoryInterface $repository, 
        QuestionServiceInterface $service
    ){
        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(){
        return [
            'index' => 'admin.question.index',
            'create' => 'admin.question.create',
            'edit' => 'admin.question.edit'
        ];
    }

    public function getRoute(){
        return [
            'index' => 'admin.question.index',
            'create' => 'admin.question.create',
            'edit' => 'admin.question.edit',
            'delete' => 'admin.question.delete'
        ];
    }
    public function index(QuestionDataTable $dataTable){
		$isAdmin = auth('admin')->user()->hasRole('superAdmin');
        return $dataTable->render($this->view['index'],[
            'isAdmin' => $isAdmin,
            'breadcrumbs' => $this->crums->add(__('Danh sách Câu hỏi'))
        ]);
    }

    public function create(){
        
        $isAdmin = auth('admin')->user()->hasRole('superAdmin');
        return view($this->view['create'],[
            'isAdmin' => $isAdmin,
            'breadcrumbs' => $this->crums->add(
                __('Danh sách Câu hỏi'),
                route($this->route['index'])
            )->add(__('Thêm mới Câu hỏi')),
        ]);
    }

    public function store(QuestionRequest $request): RedirectResponse
    {
        return $this->handleStoreResponse($request, function ($request) {
            return $this->service->store($request);
        }, $this->route['edit']);
    }

    public function edit($id){
        $isAdmin = auth('admin')->user()->hasRole('superAdmin');
        $question = $this->repository->findOrFailWithRelation($id);
        return view(
            $this->view['edit'],
            [
                'isAdmin' => $isAdmin,
                'question' => $question,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách Câu hỏi'),
                    route($this->route['index'])
                )->add(__('Chỉnh sửa Câu hỏi')),
            ]
        );

    }
 
    public function update(QuestionRequest $request): RedirectResponse
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