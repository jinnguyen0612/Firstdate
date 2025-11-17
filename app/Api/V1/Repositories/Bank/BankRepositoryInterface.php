<?php

namespace App\Api\V1\Repositories\Bank;

use App\Admin\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface BankRepositoryInterface extends EloquentRepositoryInterface
{
    public function getAllPaginate($limit = 10, $search = '');
}
