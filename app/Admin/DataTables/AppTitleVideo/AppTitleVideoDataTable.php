<?php

namespace App\Admin\DataTables\AppTitleVideo;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\AppTitleVideo\AppTitleVideoRepositoryInterface;
use App\Admin\Traits\GetConfig;
use Illuminate\Support\Facades\Log;

class AppTitleVideoDataTable extends BaseDataTable
{

    use GetConfig;
    protected $nameTable = 'appTitleVideoTable';
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        AppTitleVideoRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.app_title_video.datatable.action',
            'value' => 'admin.app_title_video.datatable.value',
            'name' => 'admin.app_title_video.datatable.name',
            'key' => 'admin.app_title_video.datatable.key',
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
        $this->customColumns = config('datatables_columns.app_title_video', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'name' => $this->view['name'],
            'key' => $this->view['key'],
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
            'value' => $this->view['value'],
        ];
    }



    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['key', 'name', 'value', 'action'];
    }


}
