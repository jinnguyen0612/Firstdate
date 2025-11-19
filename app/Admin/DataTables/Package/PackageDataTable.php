<?php

namespace App\Admin\DataTables\Package;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Package\PackageRepositoryInterface;
use App\Admin\Traits\GetConfig;
use App\Models\Package;
use Illuminate\Support\Facades\Log;

class PackageDataTable extends BaseDataTable
{

    use GetConfig;
    protected $nameTable = 'packageTable';
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        PackageRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.package.datatable.action',
            'is_active' => 'admin.package.datatable.is_active',
            'available_days' => 'admin.package.datatable.available_days',
            'discount_price' => 'admin.package.datatable.discount_price',
            'price' => 'admin.package.datatable.price',
            'name' => 'admin.package.datatable.name',
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
        $this->customColumns = config('datatables_columns.package', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'name' => $this->view['name'],
            'price' => $this->view['price'],
            'discount_price' => $this->view['discount_price'],
            'available_days' => $this->view['available_days'],
            'is_active' => $this->view['is_active'],
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
        $this->customRawColumns = ['name', 'price', 'discount_price', 'available_days', 'is_active', 'action'];
    }


}
