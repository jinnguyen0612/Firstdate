<?php

namespace App\Admin\Repositories\User;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Traits\BaseAuthCMS;
use App\Admin\Traits\Roles;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
    use Roles;
    use BaseAuthCMS;

    protected $select = [];

    public function getModel(): string
    {
        return User::class;
    }

    public function searchAllLimit(string $keySearch = '', array $meta = [], array $select = ['id', 'fullname', 'email','phone'], int $limit = 10): LengthAwarePaginator
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
                ->orWhere('fullname', 'LIKE', '%' . $key . '%');
        });
    }

    public function findOrFailWithRelation($id, $relation = ['userRelationship','userDatingTimes'])
    {
        return $this->model->with($relation)->findOrFail($id);
    }
}
