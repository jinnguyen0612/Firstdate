<?php

namespace App\Admin\DataTables\Partner;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Partner\PartnerRepositoryInterface;
use App\Admin\Traits\Roles;
use App\Enums\Partner\Gender;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class PartnerDataTable extends BaseDataTable
{
    use Roles;

    protected $nameTable = 'partnerTable';

    public function __construct(
        PartnerRepositoryInterface $repository
    ) {
        $this->repository = $repository;

        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'avatar' => 'admin.partners.datatable.avatar',
            'name' => 'admin.partners.datatable.name',
            'phone' => 'admin.partners.datatable.phone',
            'email' => 'admin.partners.datatable.email',
            'address' => 'admin.partners.datatable.address',
            'partner_category' => 'admin.partners.datatable.partner_category',
            'wallet' => 'admin.partners.datatable.wallet',
            'table' => 'admin.partners.datatable.table',
            'action' => 'admin.partners.datatable.action',
        ];
    }

    public function setColumnSearch(): void
    {
        $this->columnAllSearch = [0, 1, 2, 3, 4, 5];
    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->repository->getQueryBuilderOrderBy()->with(['province', 'district','partner_category']);
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.partner', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'avatar' => $this->view['avatar'],
            'name' => $this->view['name'],
            'phone' => $this->view['phone'],
            'email' => $this->view['email'],
            'partner_category' => $this->view['partner_category'],
            'address' => $this->view['address'],
            'wallet' => $this->view['wallet'],
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
            'table' => $this->view['table'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['avatar', 'name', 'phone', 'email', 'partner_category', 'address', 'wallet', 'table', 'action'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'name' => function ($query, $keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            },
            'partner_category' => function ($query, $keyword) {
                $query->whereHas('partner_category', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            },
            'address' => function ($query, $keyword) {
                $query->whereHas('province', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                })->orWhereHas('district', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                })->orWhere('address', 'like', '%' . $keyword . '%');
            },
        ];
    }
}
