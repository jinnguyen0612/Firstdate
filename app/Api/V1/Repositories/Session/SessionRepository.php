<?php

namespace App\Api\V1\Repositories\Session;

use App\Admin\Repositories\Session\SessionRepository as AdminSessionRepository;
use App\Enums\Classroom\ClassroomStatus;
use App\Enums\Session\SessionStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as DatabaseQueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionRepository extends AdminSessionRepository implements SessionRepositoryInterface
{
    public function getStudentClassroomSessions($userId, $date): Builder
    {
        $this->instance = $this->getQueryBuilder()
            ->join('classrooms', 'sessions.classroom_id', '=', 'classrooms.id')
            ->join('classroom_student', 'classrooms.id', '=', 'classroom_student.classroom_id')
            ->where('classroom_student.student_id', $userId)
            ->whereIn('classrooms.status', [ClassroomStatus::NotStarted->value, ClassroomStatus::InProgress->value])
            ->whereDate('sessions.date', $date) // so sánh full date
            ->select('sessions.*')
            ->with(['classroom', 'classroom.teacher']);

        return $this->instance;
    }

    public function getAllStudentSessions($userId): Builder
    {
        $this->instance = $this->getQueryBuilder()
            ->where('sessions.status',SessionStatus::Pending->value)
            ->join('classrooms', 'sessions.classroom_id', '=', 'classrooms.id')
            ->join('classroom_student', 'classrooms.id', '=', 'classroom_student.classroom_id')
            ->where('classroom_student.student_id', $userId)
            ->whereIn('classrooms.status', [ClassroomStatus::NotStarted->value, ClassroomStatus::InProgress->value])
            ->select('sessions.date')
            ->with(['classroom', 'classroom.teacher']);

        return $this->instance;
    }

    public function getAllTeacherSessions($userId): Builder
    {
        $this->instance = $this->getQueryBuilder()
            ->where('sessions.status',SessionStatus::Pending->value)
            ->join('classrooms', 'sessions.classroom_id', '=', 'classrooms.id')
            ->where('classrooms.teacher_id','=',$userId)
            ->whereIn('classrooms.status', [ClassroomStatus::NotStarted->value, ClassroomStatus::InProgress->value])
            ->select('sessions.date')
            ->with(['classroom', 'classroom.students']);

        return $this->instance;
    }

    public function getStudentSessionDetail($userId, $sessionId): Builder
    {
        $this->instance = $this->getQueryBuilder()
            ->where('id', $sessionId)
            ->with(['classroom.teacher', 'classroom.schedules', 'attendance' => function ($query) use ($userId) {
                $query->where('student_id', $userId);
            }]);

        return $this->instance;
    }

    public function getTeacherClassroomSessions($userId, $date): Builder
    {
        $this->instance = $this->getQueryBuilder()
            ->join('classrooms', 'sessions.classroom_id', '=', 'classrooms.id')
            ->join('teachers', 'teachers.id', '=', 'classrooms.teacher_id')
            ->where('teachers.id', $userId)
            ->whereIn('classrooms.status', [ClassroomStatus::NotStarted->value, ClassroomStatus::InProgress->value])
            ->whereDate('sessions.date', $date) // so sánh full date
            ->select('sessions.*')
            ->with('classroom');

        return $this->instance;
    }

    public function getTeacherSessionDetail($sessionId): Builder
    {
        $this->instance = $this->getQueryBuilder()
            ->where('id', $sessionId)
            ->with('classroom.schedules', 'attendance');

        return $this->instance;
    }

    public function getStudentAttendance($sessionId, $keySearch): Builder
    {
        $this->instance = $this->getQueryBuilder()
            ->where('id', $sessionId)
            ->with([
                'classroom',
                'attendance' => function ($query) use ($keySearch) {
                    $query->whereHas('student', function ($q) use ($keySearch) {
                        if ($keySearch) {
                            $q->where('fullname', 'LIKE', '%' . $keySearch . '%');
                        }
                    })->with('student'); // Load thêm thông tin student
                },
            ]);

        return $this->instance;
    }

    public function getTeacherClassroomSessionsHistory($userId, $date = null): Builder
    {
        $this->instance = $this->getQueryBuilder()
            ->join('classrooms', 'sessions.classroom_id', '=', 'classrooms.id')
            ->join('teachers', 'teachers.id', '=', 'classrooms.teacher_id')
            ->where('teachers.id', $userId)
            ->where('sessions.status', SessionStatus::Completed->value)
            ->whereIn('classrooms.status', [ClassroomStatus::Completed->value, ClassroomStatus::InProgress->value])
            ->when($date, function ($query) use ($date) {
                return $query->whereDate('sessions.date', $date);
            })
            ->select('sessions.*')
            ->orderBy('sessions.updated_at', 'desc')
            ->with('classroom');

        return $this->instance;
    }

    public function getTeacherWeeklySessionStats($userId): DatabaseQueryBuilder
    {
        $startOfWeek = Carbon::now()->startOfWeek(); // Mặc định là thứ 2
        $endOfWeek = Carbon::now()->endOfWeek();

        $result = DB::table('sessions')
            ->join('classrooms', 'sessions.classroom_id', '=', 'classrooms.id')
            ->join('teachers', 'teachers.id', '=', 'classrooms.teacher_id')
            ->where('teachers.id', $userId)
            ->where('sessions.status', SessionStatus::Pending->value)
            ->where('classrooms.status', ClassroomStatus::InProgress->value)
            ->selectRaw('
        COUNT(*) as total_pending,
        COUNT(CASE WHEN sessions.date BETWEEN ? AND ? THEN 1 ELSE NULL END) as pending_this_week
    ', [$startOfWeek, $endOfWeek]);

        return $result;
    }
}
