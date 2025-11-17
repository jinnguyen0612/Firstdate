<?php

namespace App\Api\V1\Repositories\Teacher;

use App\Admin\Repositories\Teacher\TeacherRepository as AdminTeacherRepository;
use App\Api\V1\Repositories\Teacher\TeacherRepositoryInterface;
use Carbon\Carbon;

class TeacherRepository extends AdminTeacherRepository implements TeacherRepositoryInterface
{

    public function getTeacherPaginate($search = null, $limit = 10)
    {

        $query = $this->getQueryBuilder();
        if ($search) {
            $query = $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }
        $this->instance = $query
            ->orderBy('id', 'desc')
            ->simplePaginate($limit);

        return $this->instance;
    }
}
