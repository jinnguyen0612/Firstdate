<?php

namespace App\Admin\DataTables\Question;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Question\QuestionRepositoryInterface;
use App\Admin\Traits\GetConfig;
use Illuminate\Support\Facades\Log;

class QuestionDataTable extends BaseDataTable
{

    use GetConfig;
    protected $nameTable = 'questionTable';
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        QuestionRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.question.datatable.action',
            'content' => 'admin.question.datatable.content',
        ];
    }

    public function setColumnSearch(): void
    {
        $this->columnAllSearch = [0, 1, 2];
        $this->columnSearchDate = [1, 2];
    }

    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }


    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.question', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'content' => $this->view['content'],
            'created_at' => '{{ format_datetime($created_at) }}',
            'updated_at' => '{{ format_datetime($updated_at) }}',
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
        $this->customRawColumns = ['content', 'created_at', 'updated_at', 'action'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'question' => function ($query, $keyword) {
                $query->where('content', 'like', '%' . $keyword . '%');
            },
        ];
    }

}
