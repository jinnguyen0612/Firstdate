<?php

namespace App\Api\V1\Repositories\User;

use App\Admin\Repositories\User\UserRepository as AdminUserRepository;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Enums\User\Gender;
use App\Enums\User\LookingFor;
use App\Models\Matching;
use App\Models\UserDatingTime;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserRepository extends AdminUserRepository implements UserRepositoryInterface
{

    public function getUserPaginate($search = null, $limit = 10)
    {

        $query = $this->getQueryBuilder();
        if ($search) {
            $query = $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }
        $this->instance = $query
            ->orderBy('id', 'desc')
            ->simplePaginate($limit);

        return $this->instance;
    }

    public function getUserNearBy($userId, $page = 1, $limit = 5)
    {
        $user = $this->getQueryBuilder()->find($userId);

        if (!$user || !$user->lat || !$user->lng) {
            return new LengthAwarePaginator([], 0, $limit, $page);
        }

        $lookingFor = $user->looking_for ?? LookingFor::Both->value;
        $lat        = (float) $user->lat;
        $lng        = (float) $user->lng;

        $likedByUser = Matching::where('user_id', $userId)
            ->pluck('user_loved_id')
            ->toArray();

        $datingTime = UserDatingTime::where('user_id', $userId)
            ->pluck('dating_time')
            ->toArray();

        $excludedUserIds = array_unique(array_merge([$userId], $likedByUser));

        $table = $this->model->getTable();

        $baseQuery = $this->model
            ->whereNotIn('id', $excludedUserIds)
            ->whereNotNull('lat')
            ->whereNotNull('lng');

        if (!empty($datingTime)) {
            $baseQuery->whereHas('userDatingTimes', function ($q) use ($datingTime) {
                $q->whereIn('dating_time', $datingTime);
            });
        }

        $baseQuery->when($lookingFor !== LookingFor::Both->value, function ($q) use ($lookingFor) {
            $genderValues = $this->mapLookingForToGender($lookingFor);
            $q->whereIn('gender', $genderValues);
        });

        // Tính distance và filter trong vòng 20km
        $baseQuery->selectRaw("
        {$table}.*,
        6371 * ACOS(
            COS(RADIANS(?)) *
            COS(RADIANS(lat)) *
            COS(RADIANS(lng) - RADIANS(?)) +
            SIN(RADIANS(?)) *
            SIN(RADIANS(lat))
        ) AS distance
    ", [$lat, $lng, $lat])
            ->having('distance', '<=', 20)
            ->orderBy('distance');

        $total = DB::query()
            ->fromSub($baseQuery, 't')
            ->count();

        if ($total === 0) {
            return new LengthAwarePaginator([], 0, $limit, $page);
        }

        $page      = max(1, (int) $page);
        $limit     = max(1, (int) $limit);
        $startIndex = (($page - 1) * $limit) % $total;

        // Lấy chunk 1 từ startIndex
        $firstChunk = (clone $baseQuery)
            ->skip($startIndex)
            ->take($limit)
            ->get();

        if ($firstChunk->count() < $limit && $total > $firstChunk->count()) {
            $remaining = $limit - $firstChunk->count();

            $extra = (clone $baseQuery)
                ->skip(0)
                ->take($remaining)
                ->get();

            $firstChunk = $firstChunk->concat($extra);
        }

        $items = $firstChunk->values();

        return new LengthAwarePaginator(
            $items,
            $total,          
            $limit,
            $page,
            [
                'path'  => request()->url(),
                'query' => request()->query(),
            ]
        );
    }

    protected function mapLookingForToGender(LookingFor $lookingFor): array
    {
        return match ($lookingFor) {
            LookingFor::Male => [Gender::Male->value, Gender::Other->value],
            LookingFor::Female => [Gender::Female->value, Gender::Other->value],
            default => [Gender::Male->value, Gender::Female->value, Gender::Other->value],
        };
    }
}
