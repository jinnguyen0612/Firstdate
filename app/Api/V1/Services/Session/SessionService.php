<?php

namespace App\Api\V1\Services\Session;

use App\Admin\Traits\AuthService as TraitsAuthService;
use App\Admin\Traits\Roles;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use App\Api\V1\Repositories\Session\SessionRepositoryInterface;
use App\Traits\UseLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class SessionService implements SessionServiceInterface
{
    use Setup, Roles, UseLog, TraitsAuthService;
    protected $data;

    protected $repository;

    protected $instance;

    public function __construct(
        SessionRepositoryInterface $repository,
    ) {
        $this->repository = $repository;
    }

    public function getStudentClassroomSessions(Request $request): Collection
    {
        $studentId = $request->user()->id;
        $date = $request->input('date');

        // Lấy danh sách classrooms của student
        $sessions = $this->repository->getStudentClassroomSessions($studentId, $date)->get();

        return $sessions;
    }

    public function getAllStudentSessions(Request $request): Collection
    {
        $studentId = $request->user()->id;

        // Lấy danh sách classrooms của student
        $sessions = $this->repository->getAllStudentSessions($studentId)->get();

        return $sessions;
    }

    public function getAllTeacherSessions(Request $request): Collection
    {
        $teacherId = $request->user()->id;

        // Lấy danh sách classrooms của teacher
        $sessions = $this->repository->getAllTeacherSessions($teacherId)->get();

        return $sessions;
    }


    public function getStudentSessionDetail(Request $request): Model
    {
        $studentId = $request->user()->id;
        $sessionId = $request->route('sessionId'); // get value from path param

        $session = $this->repository->getStudentSessionDetail($studentId, $sessionId)->firstOrFail();

        return $session;
    }

    public function updateStudentAttendance(Request $request): Model
    {
        $requestData = $request->validated();
        $sessionId = $request->route('sessionId'); // get value from path param

        $session = $this->repository->findOrFail($sessionId);

        foreach ($requestData['attendances'] as $item) {
            $session->students()->updateExistingPivot($item['student_id'], [
                'status' => $item['status'],
            ]);
        }

        return $session;
    }

    public function getTeacherClassroomSessions(Request $request): Collection
    {
        $studentId = $request->user()->id;
        $date = $request->input('date');

        // Lấy danh sách classrooms của student
        $sessions = $this->repository->getTeacherClassroomSessions($studentId, $date)->get();

        return $sessions;
    }

    public function getTeacherSessionDetail(Request $request): Model
    {
        $sessionId = $request->route('sessionId'); // get value from path param

        $session = $this->repository->getTeacherSessionDetail($sessionId)->firstOrFail();

        return $session;
    }

    public function getStudentAttendance(Request $request): Model
    {
        $sessionId = $request->route('sessionId'); // get value from path param
        $keySearch = $request->input('keySearch', '');

        $session = $this->repository->getStudentAttendance($sessionId, $keySearch)->firstOrFail();

        return $session;
    }

    public function getTeacherClassroomSessionsHistory(Request $request): Collection
    {
        $userId = $request->user()->id;
        $date = $request->input('date');

        $sessions = $this->repository->getTeacherClassroomSessionsHistory($userId, $date)->get();

        return $sessions;
    }

    public function getTeacherWeeklySessionStats(Request $request): object
    {
        $userId = $request->user()->id;

        $session = $this->repository->getTeacherWeeklySessionStats($userId)->first();
        
        $session->total_pending = $session->total_pending ?? 0;
        $session->pending_this_week = $session->pending_this_week ?? 0;

        return $session;
    }

    public function updateTeacherSessionDetail(Request $request): Model
    {
        $sessionId = $request->route('sessionId'); // get value from path param
        $status = $request->input('status');

        $session = $this->repository->update($sessionId, ['status' => $status]);

        return $session;
    }
}
