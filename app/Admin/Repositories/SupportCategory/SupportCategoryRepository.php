<?php

namespace App\Admin\Repositories\SupportCategory;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\SupportCategory\SupportCategoryRepositoryInterface;
use App\Models\SupportCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SupportCategoryRepository extends EloquentRepository implements SupportCategoryRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return SupportCategory::class;
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
