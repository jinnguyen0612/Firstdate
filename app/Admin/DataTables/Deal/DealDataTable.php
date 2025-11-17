<?php

namespace App\Admin\DataTables\Deal;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Deal\DealRepositoryInterface;
use App\Admin\Traits\GetConfig;
use App\Enums\Deal\DealStatus;
use App\Models\Deal;
use Illuminate\Support\Facades\Log;

class DealDataTable extends BaseDataTable
{

    use GetConfig;
    protected $nameTable = 'dealTable';
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        DealRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'user_female' => 'admin.deal.datatable.user_female',
            'user_male' => 'admin.deal.datatable.user_male',
            'status' => 'admin.deal.datatable.status',
            'action' => 'admin.deal.datatable.action',
        ];
    }

    public function setColumnSearch(): void
    {
        $this->columnAllSearch = [0, 1, 2, 3];
        $this->columnSearchDate = [3];
        $this->columnSearchSelect = [
            [
                'column' => 2,
                'data' => DealStatus::asSelectArray()
            ],
        ];
    }

    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy()->with(['user_male','user_female']);
    }


    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.deal', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'user_female' => $this->view['user_female'],
            'user_male' => $this->view['user_male'],
            'status' => $this->view['status'],
            'created_at' => '{{ format_date($created_at) }}',
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
        $this->customRawColumns = ['user_female', 'user_male', 'status', 'created_at', 'action'];
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
        ];
    }
}
