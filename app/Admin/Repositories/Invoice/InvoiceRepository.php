<?php

namespace App\Admin\Repositories\Invoice;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Invoice\InvoiceRepositoryInterface;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class InvoiceRepository extends EloquentRepository implements InvoiceRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return Invoice::class;
    }
    
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

    public function findByBookingId($bookingId)
    {
        return $this->model->with(['booking'])->where('booking_id',$bookingId)->first();
    }
}
