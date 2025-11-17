<?php

namespace App\Admin\DataTables\PriceList;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\PriceList\PriceListRepositoryInterface;
use App\Admin\Traits\GetConfig;
use App\Models\PriceList;
use Illuminate\Support\Facades\Log;

class PriceListDataTable extends BaseDataTable
{

    use GetConfig;
    protected $nameTable = 'priceListTable';
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        PriceListRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.price_list.datatable.action',
            'value' => 'admin.price_list.datatable.value',
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
        $this->customColumns = config('datatables_columns.price_list', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'value' => $this->view['value'],
            'price' => '{{ format_price($price) }}'
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
        $this->customRawColumns = ['value', 'price', 'action'];
    }


}
