<?php

namespace App\Admin\Http\Controllers\Booking;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Booking\BookingRequest;
use App\Admin\Repositories\Booking\BookingRepositoryInterface;
use App\Admin\Services\Booking\BookingServiceInterface;
use App\Admin\DataTables\Booking\BookingDataTable;
use App\Admin\Http\Requests\Booking\BookingUpdateRequest;
use App\Admin\Repositories\Invoice\InvoiceRepositoryInterface;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Enums\Booking\BookingStatus;
use Illuminate\Http\RedirectResponse;


class BookingController extends Controller
{
    public function __construct(
        BookingRepositoryInterface $repository, 
        BookingServiceInterface $service,
        private SettingRepositoryInterface $settingRepository,
        protected InvoiceRepositoryInterface $invoiceRepository,
    ){
        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(){
        return [
            'index' => 'admin.booking.index',
            'show' => 'admin.booking.show',
            'invoice' => 'admin.invoice.show',
        ];
    }

    public function getRoute(){
        return [
            'index' => 'admin.booking.index',
            'show' => 'admin.booking.show',
        ];
    }
    public function index(BookingDataTable $dataTable){
		
        return $dataTable->render($this->view['index'],[
            'breadcrumbs' => $this->crums->add(__('Danh sách Lịch hẹn'))
        ]);
    }

    public function show($id){
        $settings = $this->settingRepository->getAll();
        $booking = $this->repository->findOrFailWithRelation($id);
        $status = BookingStatus::asSelectArray();
        $isAdmin = auth('admin')->user()->hasRole('superAdmin');
        return view(
            $this->view['show'],
            [
                'settings' => $settings,
                'booking' => $booking,
                'status' => $status,
                'isAdmin' => $isAdmin,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách Lịch hẹn'),
                    route($this->route['index'])
                )->add(__('Chi tiết Lịch hẹn')),
            ]
        );
    }    

    public function update(BookingUpdateRequest $request): RedirectResponse
    {
        return $this->handleUpdateResponse($request, function ($request) {
            return $this->service->update($request);
        });
    } 

    public function invoice($booking_id){
        $instance = $this->invoiceRepository->findByBookingId($booking_id);
        return view($this->view['invoice'],
            [
                'invoice' => $instance,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách Lịch hẹn'),
                    route($this->route['index'])
                )->add(__('Chi tiết Lịch hẹn'),route($this->route['show'], $booking_id))
                ->add(__('Hóa đơn')),
            ]
        );
    }
}