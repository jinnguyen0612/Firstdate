<?php

namespace App\Admin\Repositories\Partner;

use App\Admin\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Admin\Repositories\Partner\PartnerRepositoryInterface;
use App\Models\Partner;
use Illuminate\Pagination\LengthAwarePaginator;

class PartnerRepository extends EloquentRepository implements PartnerRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return Partner::class;
    }
    
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

    public function searchAllLimit(string $keySearch = '', array $meta = [], array $select = ['id', 'name', 'email','phone'], int $limit = 10): LengthAwarePaginator
    {
        $this->instance = $this->getQueryBuilderOrderBy()->select($select);
        $this->getQueryBuilderFindByKey($keySearch);

        foreach ($meta as $key => $value) {
            $this->instance = $this->instance->where($key, $value);
        }

        return $this->instance->paginate($limit);
    }

    protected function getQueryBuilderFindByKey(string $key): void
    {
        $this->instance = $this->instance->where(function ($query) use ($key) {
            return $query
                ->where('email', 'LIKE', '%' . $key . '%')
                ->orWhere('phone', 'LIKE', '%' . $key . '%')
                ->orWhere('name', 'LIKE', '%' . $key . '%');
        });
    }
}
