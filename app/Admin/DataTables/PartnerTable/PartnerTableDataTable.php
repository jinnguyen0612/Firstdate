<?php

namespace App\Admin\DataTables\PartnerTable;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\PartnerTable\PartnerTableRepositoryInterface;
use App\Admin\Traits\GetConfig;
use Illuminate\Support\Facades\Log;

class PartnerTableDataTable extends BaseDataTable
{

    use GetConfig;
    protected $nameTable = 'partnerTableTable';
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        PartnerTableRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.partner_table.datatable.action',
            'name' => 'admin.partner_table.datatable.name',
            'code' => 'admin.partner_table.datatable.code',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1];
    }

    public function query()
    {
        return $this->repository->getQueryBuilder()->where('partner_id', request()->route('partner_id'))->orderBy('created_at', 'desc');
    }


    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.partner_table', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'name' => $this->view['name'],
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
        $this->customRawColumns = ['code', 'name', 'action'];
    }


}
