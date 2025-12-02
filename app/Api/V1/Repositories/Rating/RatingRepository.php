<?php

namespace App\Api\V1\Repositories\Rating;

use App\Admin\Repositories\EloquentRepository;
use App\Models\Rating;

class RatingRepository extends EloquentRepository implements RatingRepositoryInterface
{

    public function getModel(): string
    {
        return Rating::class;
    }

    public function paginate($partner_id, $limit = 10)
    {
        return $this->getQueryBuilder()->where('partner_id', $partner_id)->orderBy('created_at', 'desc')->paginate($limit);
    }

}
