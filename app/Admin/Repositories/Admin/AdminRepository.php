<?php

namespace App\Admin\Repositories\Admin;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Traits\BaseAuthCMS;
use App\Admin\Traits\Roles;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;

class AdminRepository extends EloquentRepository implements AdminRepositoryInterface
{
    use Roles;
    use BaseAuthCMS;

    protected $select = [];

    public function getModel(): string
    {
        return Admin::class;
    }

    public function getAdminByRole(string $role): Collection
    {
        return $this->model->whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        })->get();
    }

    public function searchAllLimit(string $keySearch = '', array $meta = [], array $select = ['id', 'fullname', 'email'], int $limit = 10, int $role = 0): Collection
    {
        $this->instance = $this->model->select($select)
            ->whereHas('roles', function ($query) {
                $query->where('name', $this->getRoleSupperAdmin());
            });
        $this->getQueryBuilderFindByKey($keySearch);

        foreach ($meta as $key => $value) {
            $this->instance = $this->instance->where($key, $value);
        }

        if ($role) {
            $this->instance = $this->instance->whereHas('roles', function ($query) use ($role) {
                $query->where('name', $role);
            });
        }

        return $this->instance->limit($limit)->get();
    }

    protected function getQueryBuilderFindByKey(string $key): void
    {
        $this->instance = $this->instance->where(function ($query) use ($key) {
            return $query
                ->where('email', 'LIKE', '%' . $key . '%')
                ->orWhere('fullname', 'LIKE', '%' . $key . '%');
        });
    }
}
