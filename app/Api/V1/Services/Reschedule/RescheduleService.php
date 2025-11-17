<?php

namespace App\Api\V1\Services\Reschedule;

use App\Api\V1\Services\Reschedule\RescheduleServiceInterface;
use App\Api\V1\Repositories\Reschedule\RescheduleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Api\V1\Support\AuthSupport;
use App\Admin\Traits\AuthService as TraitsAuthService;
use App\Api\V1\Repositories\Session\SessionRepositoryInterface;
use App\Enums\Reschedule\ApprovedType;
use App\Enums\Session\SessionStatus;
use App\Traits\UseLog;
use Exception;

class RescheduleService implements RescheduleServiceInterface
{
    use AuthSupport,TraitsAuthService, UseLog;

    protected $data;
    
    protected $repository;

    public function __construct(
        RescheduleRepositoryInterface $repository,
        protected SessionRepositoryInterface $sessionRepository,
    ){
        $this->repository = $repository;
    }
  
    public function createMakeupSession(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $oldSession = $this->sessionRepository->findOrFail($data['old_session_id']);
            $data['classroom_id'] = $oldSession->classroom_id;

            $newSession = [
                'classroom_id' => $data['classroom_id'],
                'date' => $data['date'],
                'start' => $data['start'],
                'end' => $data['end'],
                'content' => 'LỊCH BÙ',
                'status' => SessionStatus::Cancelled,
                'is_makeup_session' => 1,
            ];

            $newSession = $this->sessionRepository->create($newSession);

            $makeupSession = [
                'old_session_id' => $data['old_session_id'],
                'new_session_id' => $newSession->id,
                'content' => $data['content'],
            ];

            $response = $this->repository->create($makeupSession);
            DB::commit();
            return $response;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process create request', $e);
            return false;
        }
    }
}