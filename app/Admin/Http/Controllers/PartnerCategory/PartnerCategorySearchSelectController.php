<?php

namespace App\Admin\Http\Controllers\PartnerCategory;

use App\Admin\Http\Controllers\BaseSearchSelectController;
use App\Admin\Http\Resources\PartnerCategory\PartnerCategorySearchSelectResource;
use App\Admin\Repositories\PartnerCategory\PartnerCategoryRepositoryInterface;

class PartnerCategorySearchSelectController extends BaseSearchSelectController
{
    public function __construct(
        PartnerCategoryRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }
    
    protected function selectResponse(): void
    {
        $this->instance = [
            'results' => PartnerCategorySearchSelectResource::collection($this->instance->items()),
            'pagination' => [
                'more' => $this->instance->hasMorePages(),
            ],
        ];
    }


}
