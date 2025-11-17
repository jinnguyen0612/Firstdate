<?php

namespace App\Admin\Repositories\Support;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Support\SupportRepositoryInterface;
use App\Models\Support;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SupportRepository extends EloquentRepository implements SupportRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return Support::class;
    }

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

    public function searchAllLimit(string $keySearch = '', array $meta = [], array $select = ['id', 'name'], int $limit = 10, int $role = 0): LengthAwarePaginator
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
                ->orWhere('name', 'LIKE', '%' . $key . '%');
        });
    }
}
