<?php

namespace App\Admin\Services\AppTitleVideo;

use App\Admin\Services\AppTitleVideo\AppTitleVideoServiceInterface;
use  App\Admin\Repositories\AppTitleVideo\AppTitleVideoRepositoryInterface;
use App\Admin\Services\File\FileService;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use App\Traits\UseLog;
use Exception;
use Illuminate\Support\Facades\DB;

class AppTitleVideoService implements AppTitleVideoServiceInterface
{
    use Setup, UseLog;
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(AppTitleVideoRepositoryInterface $repository,
                                protected FileService $fileService) {
        $this->repository = $repository;
    }

    public function update(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->validated();
            foreach ($data['titles'] as $title) {
                $file = $title['value'];
                $title['value'] = $this->fileService->uploadAvatar('app_title_video', $file);
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
