<?php

namespace App\Admin\Repositories\Booking;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Booking\BookingRepositoryInterface;
use App\Enums\Booking\BookingStatus;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BookingRepository extends EloquentRepository implements BookingRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return Booking::class;
    }

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

    public function findOrFailWithRelation($id, $relations = ['user_female', 'user_male', 'partner'])
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    public function findByCode($code)
    {
        return $this->model->where('code', $code)->first();
    }


    public function getNewBookingPartner($search = null, $date = null)
    {
        $query = $this->model->where('status', BookingStatus::Pending->value);

        if ($search) {
            $query = $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%$search%")
                    ->orWhereHas('user_female', function ($q) use ($search) {
                        $q->where('fullname', 'like', "%$search%");
                    })
                    ->orWhereHas('user_male', function ($q) use ($search) {
                        $q->where('fullname', 'like', "%$search%");
                    });
            });
        }


        if ($date) {
            $query = $query->whereDate('date', $date);
        }

        $query = $query->whereHas('deal.dealDateOptions', fn($q) => $q->where('is_chosen', 1))
            ->with([
                'user_female',
                'user_male',
                'deal.dealDateOptions' => fn($q) => $q->where('is_chosen', 1)
                    ->select('id', 'deal_id', 'from', 'to', 'is_chosen'),
            ])
            ->orderBy('created_at', 'DESC')
            ->get()
            ->map(function ($booking) {
                $chosenOption = $booking->deal->dealDateOptions->first();
                return [
                    'data' => $booking,
                    'from' => $chosenOption?->from,
                    'to' => $chosenOption?->to,
                ];
            });
        return $query;
    }

    public function getComfirmBookingPartner($status = BookingStatus::Confirmed->value , $search = null, $date = null)
    {
        if ($status) {
            $query = $this->model->where('status', $status)->with('user_female', 'user_male');
        } else {
            $query = $this->model->where('status', '!=', BookingStatus::Pending->value)->with('user_female', 'user_male');
        }

        if($search) {
            $query = $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%$search%")
                    ->orWhereHas('user_female', function ($q) use ($search) {
                        $q->where('fullname', 'like', "%$search%");
                    })
                    ->orWhereHas('user_male', function ($q) use ($search) {
                        $q->where('fullname', 'like', "%$search%");
                    });
            });
        }

        if ($date) {
            $query = $query->whereDate('date', $date);
        }

        $query = $query->orderBy('created_at', 'DESC');

        return $query->get();
    }

    public function findByCodePartner($code)
    {
        $booking = $this->model
            ->where('code', $code)
            ->whereHas('deal.dealDateOptions', fn($q) => $q->where('is_chosen', 1))
            ->with([
                'user_female',
                'user_male',
                'deal.dealDateOptions' => fn($q) => $q->where('is_chosen', 1)
                    ->select('id', 'deal_id', 'from', 'to', 'is_chosen'),
            ])
            ->first();

        if (!$booking) {
            return null;
        }

        $chosenOption = $booking->deal->dealDateOptions->first();

        return [
            'data' => $booking,
            'from' => $chosenOption?->from,
            'to' => $chosenOption?->to,
        ];
    }
}
