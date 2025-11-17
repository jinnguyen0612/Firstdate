<?php

namespace App\Api\V1\Repositories\Booking;

use App\Admin\Repositories\Booking\BookingRepository as AdminBookingRepository;
use App\Api\V1\Repositories\Booking\BookingRepositoryInterface;
use App\Models\Booking;

class BookingRepository extends AdminBookingRepository implements BookingRepositoryInterface
{

    public function paginate($page = 1, $limit = 10)
    {
        $page = $page ? $page - 1 : 0;
        $this->instance = $this->model
            ->offset($page * $limit)
            ->limit($limit)
            ->orderBy('id', 'desc')
            ->get();
        return $this->instance;
    }

}