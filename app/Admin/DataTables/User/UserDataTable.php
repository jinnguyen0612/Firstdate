<?php

namespace App\Admin\DataTables\User;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Traits\AuthService;
use App\Admin\Traits\Roles;
use App\Enums\User\Gender;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class UserDataTable extends BaseDataTable
{
    use Roles, AuthService;

    protected $nameTable = 'userTable';

    public function __construct(
        UserRepositoryInterface $repository
    ) {
        $this->repository = $repository;

        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'avatar' => 'admin.users.datatable.avatar',
            'fullname' => 'admin.users.datatable.fullname',
            'phone' => 'admin.users.datatable.phone',
            'email' => 'admin.users.datatable.email',
            'gender' => 'admin.users.datatable.gender',
            'address' => 'admin.users.datatable.address',
            'wallet' => 'admin.users.datatable.wallet',
            'is_hide' => 'admin.users.datatable.is_hide',
            'action' => 'admin.users.datatable.action',
        ];
    }

    public function setColumnSearch(): void
    {
        $this->columnAllSearch = [1, 2, 3, 4, 5, 7];
        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => Gender::asSelectArray()
            ],
            [
                'column' => 7,
                'data' => [0 => 'Đang hiển thị', 1 => 'Đã ẩn']
            ],
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->repository->getQueryBuilderOrderBy()->with(['province', 'district']);
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.user', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'avatar' => $this->view['avatar'],
            'fullname' => $this->view['fullname'],
            'phone' => $this->view['phone'],
            'email' => $this->view['email'],
            'gender' => $this->view['gender'],
            'address' => $this->view['address'],
            'wallet' => $this->view['wallet'],
            'is_hide' => $this->view['is_hide'],
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
        $this->customRawColumns = ['avatar', 'fullname', 'phone', 'email', 'gender', 'address', 'wallet', 'is_hide', 'action'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'fullname' => function ($query, $keyword) {
                $query->where('fullname', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            },
            'address' => function ($query, $keyword) {
                $query->whereHas('province', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                })->orWhereHas('district', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}
