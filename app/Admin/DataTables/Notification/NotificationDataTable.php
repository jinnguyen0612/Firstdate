<?php

namespace App\Admin\DataTables\Notification;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Enums\Notification\NotificationStatus;
use Illuminate\Database\Eloquent\Builder;

class NotificationDataTable extends BaseDataTable
{

    protected $nameTable = 'notificationTable';

    protected array $actions = ['reset', 'reload'];

    public function __construct(
        NotificationRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }
    protected function setColumnSearch()
    {
        $this->columnAllSearch = [1, 2, 3, 4, 5, 6, 7, 8, 9];

        $this->columnSearchDate = [9];

        $this->columnSearchSelect = [
            [
                'column' => 7,
                'data' => NotificationStatus::asSelectArray()
            ],
        ];
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.notifications.datatable.action',
            'status' => 'admin.notifications.datatable.status',
            'user' => 'admin.notifications.datatable.user',
            'partner' => 'admin.notifications.datatable.partner',
            'id' => 'admin.notifications.datatable.id',
            'checkbox' => 'admin.notifications.datatable.checkbox',
        ];
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'status' => $this->view['status'],
            'user' => $this->view['user'],
            'partner' => $this->view['partner'],
            'id' => $this->view['id'],
            'created_at' => '{{ format_date($created_at,\'d-m-Y\') }}',
            'read_at' => '{{ format_datetime($read_at) }}',

        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->repository->getByQueryBuilder([], ['partner', 'user']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */

    /**
     * Get columns.
     *
     * @return void
     */
    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.notification', []);
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'checkbox' => $this->view['checkbox'],
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['id', 'status', 'user', 'partner', 'action', 'message', 'checkbox'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'user' => function ($query, $keyword) {
                $query->whereHas('user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%')
                        ->orWhere('email', 'like', '%' . $keyword . '%')
                        ->orWhere('phone', 'like', '%' . $keyword . '%');
                });
            },
            'partner' => function ($query, $keyword) {
                $query->whereHas('partner', function ($subQuery) use ($keyword) {
                    $subQuery->where('name', 'like', '%' . $keyword . '%')
                            ->orWhere('email', 'like', '%' . $keyword . '%')
                            ->orWhere('phone', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}
