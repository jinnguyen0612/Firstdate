<?php

namespace App\Api\V1\Repositories\Deal;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Traits\AuthService;
use App\Api\V1\Repositories\Deal\DealRepositoryInterface;
use App\Enums\Booking\BookingStatus;
use App\Enums\Deal\DealStatus;
use App\Models\Deal;
use Illuminate\Http\Request;

class DealRepository extends EloquentRepository implements DealRepositoryInterface
{
    use AuthService;

    protected $select = [];

    public function getModel(): string
    {
        return Deal::class;
    }

    public function findOrFailWithStatus($id, $status = null)
    {
        if ($status) {
            return $this->model->where('status', $status)->findOrFail($id);
        } else {
            return $this->model->findOrFail($id);
        }
    }

    public function getDealByCurrentUser($limit = 10, $status = null)
    {
        $userId = $this->getCurrentUserId();

        $query = $this->model
            ->with(['user_male', 'user_female', 'dealDateOptions', 'dealDistrictOptions', 'dealPartnerOptions', 'booking'])
            ->where(function ($q) use ($userId) {
                $q->where('user_male_id', $userId)
                    ->orWhere('user_female_id', $userId);
            });

        if ($status) {
            $query->where(function ($q) use ($status) {
                if ($status === DealStatus::Pending->value) {
                    $q->where('status', DealStatus::Pending->value)
                        ->orWhereHas('booking', function ($b) {
                            $b->where('status', BookingStatus::Confirmed->value);
                        });
                }

                elseif ($status === BookingStatus::Processing->value) {
                    $q->whereHas('booking', function ($b) use ($status) {
                        $b->where('status', $status);
                    });
                }

                elseif ($status === BookingStatus::Cancelled->value) {
                    $q->where('status', DealStatus::Cancelled->value)
                        ->orWhereHas('booking', function ($b) {
                            $b->where('status', BookingStatus::Cancelled->value);
                        });
                }

                elseif ($status === BookingStatus::Completed->value) {
                    $q->where('status', BookingStatus::Completed->value)
                        ->orWhereHas('booking', function ($b) {
                            $b->where('status', BookingStatus::Completed->value);
                        });
                }
            });
        }

        return $query->orderBy('created_at', 'desc')->simplePaginate($limit);
    }


    public function findDeal($id)
    {
        return $this->model->with(['user_male', 'user_female', 'dealDateOptions', 'dealDistrictOptions', 'dealPartnerOptions'])->find($id);
    }

    public function getDeal($user_id)
    {
        $currentUserId = $this->getCurrentUserId();

        return $this->model->with(['user_male', 'user_female', 'dealDateOptions', 'dealDistrictOptions', 'dealPartnerOptions'])->where(function ($query) use ($user_id, $currentUserId) {
            $query->where('user_male_id', $user_id)
                ->where('user_female_id', $currentUserId);
        })->orWhere(function ($query) use ($user_id, $currentUserId) {
            $query->where('user_male_id', $currentUserId)
                ->where('user_female_id', $user_id);
        })->latest()->first();
    }
}
