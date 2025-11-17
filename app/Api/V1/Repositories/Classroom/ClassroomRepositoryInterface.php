<?php

namespace App\Api\V1\Repositories\Classroom;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface ClassroomRepositoryInterface extends EloquentRepositoryInterface
{
    public function getClassroomByStatusPaginate($search,$status,$limit);
    public function getNotStartClassroomPaginate($limit);
    public function getClassroomByStudentPaginate($id, $status, $limit);
    public function showClassroomByStudent($id, $studentId);
    public function getClassroomByTeacherPaginate($id, $status, $limit);
    public function getAvailableClassroomByTeacherPaginate($id, $date, $limit);
    public function showClassroomByTeacher($id, $studentId);
    public function searchAndFilterClassroom($id, $search, $filter, $limit);
}