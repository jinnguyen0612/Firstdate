<?php

namespace App\Admin\DataTables\Transaction;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Admin\Traits\GetConfig;
use App\Enums\Transaction\TransactionStatus;
use App\Enums\Transaction\TransactionType;
use Illuminate\Support\Facades\Log;

class TransactionDataTable extends BaseDataTable
{

    use GetConfig;
    protected $nameTable = 'transactionTable';
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        TransactionRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.transaction.datatable.action',
            'status' => 'admin.transaction.datatable.status',
            'type' => 'admin.transaction.datatable.type',
            'amount' => 'admin.transaction.datatable.amount',
            'to' => 'admin.transaction.datatable.to',
            'from' => 'admin.transaction.datatable.from',
            'code' => 'admin.transaction.datatable.code',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 4, 5, 6];
        $this->columnSearchDate = [6];
        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => TransactionType::asSelectArray()
            ],
            [
                'column' => 5,
                'data' => TransactionStatus::asSelectArray()
            ],
        ];
    }

    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy()->with(['from','to']);
    }


    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.transaction', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'code' => $this->view['code'],
            'from' => $this->view['from'],
            'to' => $this->view['to'],
            'amount' => $this->view['amount'],
            'type' => $this->view['type'],
            'status' => $this->view['status'],
            'created_at' => '{{ format_datetime($created_at) }}',
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
        $this->customRawColumns = ['code', 'from', 'to', 'amount', 'type', 'status', 'action'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'code' => function ($query, $keyword) {
                $query->where('code', 'like', '%' . $keyword . '%');
            },
            'from' => function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where(function ($sub) use ($keyword) {
                        $sub->where('from_type', \App\Models\User::class)
                            ->whereHas('from', function ($q2) use ($keyword) {
                                $q2->where('fullname', 'like', '%' . $keyword . '%');
                            });
                    })->orWhere(function ($sub) use ($keyword) {
                        $sub->where('from_type', \App\Models\Partner::class)
                            ->whereHas('from', function ($q2) use ($keyword) {
                                $q2->where('name', 'like', '%' . $keyword . '%');
                            });
                    });
                });
            },
            'to' => function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where(function ($sub) use ($keyword) {
                        $sub->where('to_type', \App\Models\User::class)
                            ->whereHas('to', function ($q2) use ($keyword) {
                                $q2->where('fullname', 'like', '%' . $keyword . '%');
                            });
                    })->orWhere(function ($sub) use ($keyword) {
                        $sub->where('to_type', \App\Models\Partner::class)
                            ->whereHas('to', function ($q2) use ($keyword) {
                                $q2->where('name', 'like', '%' . $keyword . '%');
                            });
                    });
                });
            },
        ];
    }
}
