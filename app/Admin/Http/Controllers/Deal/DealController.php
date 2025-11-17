<?php

namespace App\Admin\Http\Controllers\Deal;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Deal\DealRequest;
use App\Admin\Repositories\Deal\DealRepositoryInterface;
use App\Admin\Services\Deal\DealServiceInterface;
use App\Admin\DataTables\Deal\DealDataTable;
use App\Admin\Http\Requests\Deal\DealUpdateRequest;
use App\Admin\Repositories\Invoice\InvoiceRepositoryInterface;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Enums\Deal\DealStatus;
use Illuminate\Http\RedirectResponse;


class DealController extends Controller
{
    public function __construct(
        DealRepositoryInterface $repository, 
    ){
        parent::__construct();
        $this->repository = $repository;
    }

    public function getView(){
        return [
            'index' => 'admin.deal.index',
            'show' => 'admin.deal.show',
        ];
    }

    public function getRoute(){
        return [
            'index' => 'admin.deal.index',
            'show' => 'admin.deal.show',
        ];
    }
    public function index(DealDataTable $dataTable){
		
        return $dataTable->render($this->view['index'],[
            'breadcrumbs' => $this->crums->add(__('Danh sách kèo'))
        ]);
    }

    public function show($id){
        $deal = $this->repository->findOrFailWithRelation($id);
        $booking = $deal->booking;
        return view(
            $this->view['show'],
            [
                'deal' => $deal,
                'booking' => $booking,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách kèo'),
                    route($this->route['index'])
                )->add(__('Tiến trình lên kèo')),
            ]
        );
    }    
}