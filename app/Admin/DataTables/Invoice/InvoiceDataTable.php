<?php

namespace App\Admin\DataTables\Invoice;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Invoice\InvoiceRepositoryInterface;
use App\Admin\Traits\GetConfig;
use Illuminate\Support\Facades\Log;

class InvoiceDataTable extends BaseDataTable
{

    use GetConfig;
    protected $nameTable = 'invoiceTable';
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        InvoiceRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'user_female' => 'admin.invoice.datatable.user_female',
            'user_male' => 'admin.invoice.datatable.user_male',
            'partner' => 'admin.invoice.datatable.partner',
            'date' => 'admin.invoice.datatable.date',
            'action' => 'admin.invoice.datatable.action',
        ];
    }

    public function setColumnSearch(): void
    {
        $this->columnAllSearch = [0, 1, 2, 3];
        $this->columnSearchDate = [3];
    }

    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy()->with(['user_female','user_male','partner','partner.district','partner.province']);
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
                            ->orWhereHas('district', function ($q) use ($keyword){
                                $q->where('name','like', '%' . $keyword . '%');
                            })
                            ->orWhereHas('province', function ($q) use ($keyword){
                                $q->where('name','like', '%' . $keyword . '%');
                            });
                });
            },
        ];
    }
}
