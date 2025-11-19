<?php

namespace App\Api\V1\Repositories\Partner;
use App\Admin\Repositories\Partner\PartnerRepository as AdminPartnerRepository;
use App\Api\V1\Repositories\Partner\PartnerRepositoryInterface;

class PartnerRepository extends AdminPartnerRepository implements PartnerRepositoryInterface
{
    public function getPartnerByDistrict($district_id, $search = "", $limit = 10)
    {
        return $this->getQueryBuilder()->where('district_id', $district_id)
            ->where('is_active', 1)
            ->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                      ->orWhere('address', 'LIKE', '%' . $search . '%');
            })
            ->paginate($limit);
    }
}
