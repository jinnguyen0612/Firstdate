<?php

namespace App\Admin\DataTables\PartnerCategory;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\PartnerCategory\PartnerCategoryRepositoryInterface;
use App\Admin\Traits\GetConfig;
use Illuminate\Support\Facades\Log;

class PartnerCategoryDataTable extends BaseDataTable
{

    use GetConfig;
    protected $nameTable = 'partnerCategoryTable';
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        PartnerCategoryRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.partner_categories.datatable.action',
            'name' => 'admin.partner_categories.datatable.name',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1];
    }

    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }


    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.partner_category', []);
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
        $this->customRawColumns = ['name', 'action'];
    }


}
