<?php

namespace App\Admin\Repositories\Transaction;
use App\Admin\Repositories\EloquentRepositoryInterface;
use App\Models\Partner;

interface TransactionRepositoryInterface extends EloquentRepositoryInterface
{
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
    public function findOrFailWithRelation($id, $relations);
    public function getTransactionByPartner(Partner $partner, $limit = 10);
    public function countTransactionByPartner(Partner $partner);
    public function createTransaction($model_from = null, $model_to = null, $amount = 0, $type, $status, $image = null, $description = null);
    public function getUserProfit();
    public function getPartnerProfit();
}
