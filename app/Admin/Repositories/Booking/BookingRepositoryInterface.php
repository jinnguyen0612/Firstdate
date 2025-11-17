<?php

namespace App\Admin\Repositories\Booking;
use App\Admin\Repositories\EloquentRepositoryInterface;
use App\Enums\Booking\BookingStatus;

interface BookingRepositoryInterface extends EloquentRepositoryInterface
{
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
    public function findOrFailWithRelation($id, $relations);
    public function findByCode($code);
    public function findByCodePartner($code);
    public function getNewBookingPartner($search = null, $date = null);
    public function getComfirmBookingPartner($status = BookingStatus::Confirmed->value, $search = null, $date = null);
}
