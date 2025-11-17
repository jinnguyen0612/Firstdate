<?php

namespace App\Admin\Http\Controllers\Partner;

use App\Admin\Http\Controllers\BaseSearchSelectController;
use App\Admin\Repositories\Partner\PartnerRepositoryInterface;
use App\Admin\Http\Resources\Partner\PartnerSearchSelectResource;

class PartnerSearchSelectController extends BaseSearchSelectController
{
    public function __construct(
        PartnerRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    protected function selectResponse(): void
    {
        $this->instance = [
            'results' => PartnerSearchSelectResource::collection($this->instance->getCollection()),
            'pagination' => [
                'more' => $this->instance->hasMorePages()
            ]
        ];
    }
}
