<?php

namespace App\Api\V1\Services\Rating;

use App\Admin\Services\File\FileService;
use App\Admin\Traits\AuthService as TraitsAuthService;
use App\Admin\Traits\Roles;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use App\Api\V1\Repositories\Rating\RatingRepositoryInterface;
use App\Traits\UseLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class RatingService implements RatingServiceInterface
{
    use Setup, Roles, UseLog, TraitsAuthService;
    protected $data;

    protected $repository;

    protected $instance;

    public function __construct(
        RatingRepositoryInterface $repository,
        protected FileService $fileService,
    ) {
        $this->repository = $repository;
    }

    public function create(Request $data){
        $this->data = $data->validated();
        $currentUser = $this->getCurrentUser();

        $isExists = $this->repository->getQueryBuilder()->where('user_id', $currentUser->id)->where('partner_id', $this->data['partner_id'])->first();
        if($isExists){
            return false;
        }

        $this->data['user_id'] = $currentUser->id;

        return $this->repository->create($this->data);
    }

    public function update(Request $data){
        $this->data = $data->validated();

        return $this->repository->update($this->data['id'], $this->data);
    }
}
