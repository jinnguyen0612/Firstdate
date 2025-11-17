<?php

namespace App\Api\V1\Repositories\Booking;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface BookingRepositoryInterface extends EloquentRepositoryInterface
{
    public function paginate($page = 1, $limit = 10);
}