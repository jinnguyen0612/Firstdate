<?php

namespace App\Api\V1\Repositories\Session;

use App\Admin\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as DatabaseQueryBuilder;
use Illuminate\Http\Request;

interface SessionRepositoryInterface extends EloquentRepositoryInterface
{
    public function getStudentClassroomSessions($userId, $date): Builder;
    public function getAllStudentSessions($userId): Builder;
    public function getAllTeacherSessions($userId): Builder;
    public function getStudentSessionDetail($userId, $sessionId): Builder;
    public function getTeacherClassroomSessions($userId, $date): Builder;
    public function getTeacherSessionDetail($sessionId): Builder;
    public function getStudentAttendance($sessionId, $keySearch): Builder;
    public function getTeacherClassroomSessionsHistory($userId, $date): Builder;
    public function getTeacherWeeklySessionStats($userId): DatabaseQueryBuilder;
}
