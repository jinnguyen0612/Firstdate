<?php

namespace App\Api\V1\Repositories\OTP;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Traits\BaseAuthCMS;
use App\Admin\Traits\Roles;
use App\Api\V1\Repositories\Otp\OtpRepositoryInterface;
use App\Models\Otp;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class OtpRepository extends EloquentRepository implements OtpRepositoryInterface
{
    use Roles;
    use BaseAuthCMS;

    protected $select = [];

    public function getModel(): string
    {
        return Otp::class;
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

}
