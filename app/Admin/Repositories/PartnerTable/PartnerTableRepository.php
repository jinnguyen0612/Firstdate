<?php

namespace App\Admin\Repositories\PartnerTable;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\PartnerTable\PartnerTableRepositoryInterface;
use App\Models\PartnerTable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PartnerTableRepository extends EloquentRepository implements PartnerTableRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return PartnerTable::class;
    }
    
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

    public function searchAllLimit($partner_id , string $keySearch = '', array $meta = [], array $select = ['id', 'name', 'code'], int $limit = 10, int $role = 0): LengthAwarePaginator
    {
        $this->instance = $this->getQueryBuilderOrderBy()->select($select)->where('partner_id', $partner_id);
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
                ->orWhere('name', 'LIKE', '%' . $key . '%');
        });
    }
}
