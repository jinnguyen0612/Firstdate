<?php

namespace App\Api\V1\Repositories\Partner;
use App\Admin\Repositories\EloquentRepositoryInterface;


interface PartnerRepositoryInterface extends EloquentRepositoryInterface
{
    public function getPartnerByDistrict($district_id, $search = "", $limit = 10);
}
