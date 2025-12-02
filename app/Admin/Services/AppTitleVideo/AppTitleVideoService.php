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

    public function __construct(
        AppTitleVideoRepositoryInterface $repository,
        protected FileService $fileService
    ) {
        $this->repository = $repository;
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $data   = $request->validated();
            $base64 = $data['value'] ?? null;

            if ($base64) {
                // ví dụ lưu trong folder 'app_title_videos'
                $path = $this->fileService->uploadBase64('app_title_videos', $base64);
                $data['value'] = $path;
            } else {
                // không gửi value mới thì giữ video cũ
                unset($data['value']);
            }

            $this->repository->update($data['id'], $data);

            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->logError('Failed to update', $e);
            return false;
        }
    }
}
