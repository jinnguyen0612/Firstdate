<?php

namespace App\Admin\DataTables\Booking;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Booking\BookingRepositoryInterface;
use App\Admin\Traits\GetConfig;
use Illuminate\Support\Facades\Log;

class BookingDataTable extends BaseDataTable
{

    use GetConfig;
    protected $nameTable = 'bookingTable';
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        BookingRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'user_female' => 'admin.booking.datatable.user_female',
            'user_male' => 'admin.booking.datatable.user_male',
            'partner' => 'admin.booking.datatable.partner',
            'date' => 'admin.booking.datatable.date',
            'action' => 'admin.booking.datatable.action',
        ];
    }

    public function setColumnSearch(): void
    {
        $this->columnAllSearch = [0, 1, 2, 3, 4];
        $this->columnSearchDate = [4];
    }

    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy()->with(['user_female', 'user_male', 'partner', 'partner.district', 'partner.province', 'deal.dealTime']);
    }


    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.booking', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'user_female' => $this->view['user_female'],
            'user_male' => $this->view['user_male'],
            'partner' => $this->view['partner'],
            'date' => $this->view['date'],
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }



    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['user_female', 'user_male', 'partner', 'date', 'action'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'user_female' => function ($query, $keyword) {
                $query->whereHas('user_female', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%')
                        ->orWhere('email', 'like', '%' . $keyword . '%')
                        ->orWhere('phone', 'like', '%' . $keyword . '%');
                });
            },
            'user_male' => function ($query, $keyword) {
                $query->whereHas('user_male', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%')
                        ->orWhere('email', 'like', '%' . $keyword . '%')
                        ->orWhere('phone', 'like', '%' . $keyword . '%');
                });
            },
            'partner' => function ($query, $keyword) {
                $query->whereHas('partner', function ($subQuery) use ($keyword) {
                    $subQuery->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('address', 'like', '%' . $keyword . '%')
                        ->orWhereHas('district', function ($q) use ($keyword) {
                            $q->where('name', 'like', '%' . $keyword . '%');
                        })
                        ->orWhereHas('province', function ($q) use ($keyword) {
                            $q->where('name', 'like', '%' . $keyword . '%');
                        });
                });
            },
        ];
    }
}
