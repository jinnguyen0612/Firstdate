<?php

namespace App\Admin\Services\AppTitle;

use App\Admin\Services\AppTitle\AppTitleServiceInterface;
use  App\Admin\Repositories\AppTitle\AppTitleRepositoryInterface;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use App\Traits\UseLog;
use Exception;
use Illuminate\Support\Facades\DB;

class AppTitleService implements AppTitleServiceInterface
{
    use Setup, UseLog;
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;
    
    protected $repository;

    public function __construct(AppTitleRepositoryInterface $repository){
        $this->repository = $repository;
    }

    public function update(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->validated();
            foreach ($data['titles'] as $title) {
                $this->repository->update($title['id'],$title);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to update', $e);
            return false;
        }
    }

}