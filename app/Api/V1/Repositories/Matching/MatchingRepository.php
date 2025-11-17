<?php

namespace App\Api\V1\Repositories\Matching;

use App\Admin\Repositories\EloquentRepository;
use App\Api\V1\Repositories\Matching\MatchingRepositoryInterface;
use App\Enums\User\UserStatus;
use App\Models\Matching;
use App\Models\User;
use Illuminate\Http\Request;

class MatchingRepository extends EloquentRepository implements MatchingRepositoryInterface
{
    protected $select = [];

    public function getModel(): string
    {
        return Matching::class;
    }

    public function getMatchingSuccess(int $userId, string $searchTerm = '', int $limit = 10)
    {
        $query = User::query()
            ->select('users.*')
            ->addSelect([
                'is_supper_love' => Matching::select('is_supper_love')
                    ->whereColumn('matchings.user_id', 'users.id')
                    ->where('matchings.user_loved_id', $userId)
                    ->limit(1),

                'support_money' => Matching::select('support_money')
                    ->whereColumn('matchings.user_id', 'users.id')
                    ->where('matchings.user_loved_id', $userId)
                    ->limit(1),
            ])
            ->where('users.status', UserStatus::Active->value)
            ->where('users.id', '!=', $userId)

            ->whereExists(function ($q) use ($userId) {
                $q->selectRaw(1)
                    ->from('matchings as l2')
                    ->whereColumn('l2.user_id', 'users.id')
                    ->where('l2.user_loved_id', $userId);
            })

            ->whereExists(function ($q) use ($userId) {
                $q->selectRaw(1)
                    ->from('matchings as l1')
                    ->whereColumn('l1.user_loved_id', 'users.id')
                    ->where('l1.user_id', $userId);
            })
            ->when($searchTerm, function ($q) use ($searchTerm) {
                $q->where('users.fullname', 'LIKE', "%{$searchTerm}%");
            });

        return $query->simplePaginate($limit);
    }



    public function getUnmatchedLovers(int $userId, int $limit = 10)
    {
        return User::query()
            ->select('users.*')
            ->addSelect([
                'is_supper_love' => Matching::select('is_supper_love')
                    ->whereColumn('matchings.user_id', 'users.id')
                    ->where('matchings.user_loved_id', $userId)
                    ->limit(1),

                'support_money' => Matching::select('support_money')
                    ->whereColumn('matchings.user_id', 'users.id')
                    ->where('matchings.user_loved_id', $userId)
                    ->limit(1),
            ])
            ->where('id', '!=', $userId)
            ->where('status', UserStatus::Active->value)

            ->whereExists(function ($q) use ($userId) {
                $q->selectRaw(1)
                    ->from('matchings as l1')
                    ->whereColumn('l1.user_id', 'users.id')
                    ->where('l1.user_loved_id', $userId);
            })

            ->whereNotExists(function ($q) use ($userId) {
                $q->selectRaw(1)
                    ->from('matchings as l2')
                    ->whereColumn('l2.user_loved_id', 'users.id')
                    ->where('l2.user_id', $userId);
            })

            ->simplePaginate($limit);
    }



    public function deleteBy(array $conditions)
    {
        return $this->getModel()::where($conditions)->delete();
    }
}
