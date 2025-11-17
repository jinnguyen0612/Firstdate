<?php

namespace App\Api\V1\Services\Session;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface SessionServiceInterface
{
    public function getStudentClassroomSessions(Request $request): Collection;
    public function getAllStudentSessions(Request $request): Collection;
    public function getAllTeacherSessions(Request $request): Collection;
    public function getStudentSessionDetail(Request $request): Model;
    public function updateStudentAttendance(Request $request): Model;
    public function getTeacherClassroomSessions(Request $request): Collection;
    public function getTeacherSessionDetail(Request $request): Model;
    public function getStudentAttendance(Request $request): Model;
    public function getTeacherClassroomSessionsHistory(Request $request): Collection;
    public function getTeacherWeeklySessionStats(Request $request): object;
    public function updateTeacherSessionDetail(Request $request): Model;
}
