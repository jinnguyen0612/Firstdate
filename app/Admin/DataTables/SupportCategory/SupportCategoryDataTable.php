<?php

namespace App\Admin\DataTables\SupportCategory;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\SupportCategory\SupportCategoryRepositoryInterface;
use App\Admin\Traits\GetConfig;
use Illuminate\Support\Facades\Log;

class SupportCategoryDataTable extends BaseDataTable
{

    use GetConfig;
    protected $nameTable = 'supportCategoryTable';
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        SupportCategoryRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.support_category.datatable.action',
            'support' => 'admin.support_category.datatable.support',
            'title' => 'admin.support_category.datatable.title',
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
        $this->customColumns = config('datatables_columns.support_category', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'title' => $this->view['title'],
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
            'support' => $this->view['support'],
        ];
    }



    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['title', 'action', 'support'];
    }


}
