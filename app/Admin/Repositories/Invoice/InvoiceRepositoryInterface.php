<?php

namespace App\Admin\Repositories\Invoice;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface InvoiceRepositoryInterface extends EloquentRepositoryInterface
{
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
    public function findByBookingId($bookingId);
}
