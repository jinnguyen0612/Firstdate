<?php

namespace App\Api\V1\Repositories\PriceList;

use App\Admin\Repositories\EloquentRepositoryInterface;
use App\Admin\Repositories\PriceList\PriceListRepositoryInterface as AdminPriceListRepositoryInterface;
use Illuminate\Http\Request;

interface PriceListRepositoryInterface extends AdminPriceListRepositoryInterface
{
    public function getAll();
    public function paginate($limit = 10);
}
