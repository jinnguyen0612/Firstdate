<?php

namespace App\Admin\Http\Controllers\PartnerTable;

use App\Admin\Http\Controllers\BaseSearchSelectController;
use App\Admin\Http\Resources\PartnerTable\PartnerTableSearchSelectResource;
use App\Admin\Repositories\PartnerTable\PartnerTableRepositoryInterface;

class PartnerTableSearchSelectController extends BaseSearchSelectController
{
    public function __construct(
        PartnerTableRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    protected function data()
    {
        $this->instance = $this->repository->searchAllLimit(
            $this->request->input('partner_id', ''),
            $this->request->input('term', ''),
            $this->request->except('term', '_type', 'q', 'page', 'partner_id') // extra 'where' conditions can be applied via the 'meta' parameter.
        );
    }

    protected function selectResponse(): void
    {
        $this->instance = [
            'results' => PartnerTableSearchSelectResource::collection($this->instance->items()),
            'pagination' => [
                'more' => $this->instance->hasMorePages(),
            ],
        ];
    }
}
