<?php

namespace App\Admin\DataTables\Support;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Support\SupportRepositoryInterface;
use App\Admin\Traits\GetConfig;
use Illuminate\Support\Facades\Log;

class SupportDataTable extends BaseDataTable
{

    use GetConfig;
    protected $nameTable = 'supportTable';
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        SupportRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.support.datatable.action',
            'title' => 'admin.support.datatable.title',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1];
    }

    public function query()
    {
        Log::info($this->repository->getQueryBuilder()
            ->where('support_category_id', request()->route('support_category_id'))
            ->orderBy('created_at', 'desc')->get());
        return $this->repository->getQueryBuilder()
            ->where('support_category_id', request()->route('support_category_id'))
            ->orderBy('created_at', 'desc');
    }



    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.support', []);
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
        ];
    }



    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['title', 'action'];
    }
}
