<?php

namespace App\Api\V1\Repositories\Classroom;

use App\Admin\Repositories\Classroom\ClassroomRepository as AdminClassroomRepository;
use App\Api\V1\Repositories\Classroom\ClassroomRepositoryInterface;
use App\Enums\Classroom\ClassroomFilter;
use App\Enums\Classroom\ClassroomStatus;
use Carbon\Carbon;

class ClassroomRepository extends AdminClassroomRepository implements ClassroomRepositoryInterface
{

    public function getClassroomByStatusPaginate($search = null, $status = null, $limit = 10){

        $query = $this->getQueryBuilder()->with(['teacher']);

        if($status){
            $query = $query->where('status',$status);
        }

        if ($search) {
            $query = $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhereHas('teacher', function ($q) use ($search) {
                    $q->where('fullname', 'like', "%$search%");
                });
            });
        }

        $this->instance = $query
            ->orderBy('id', 'desc')
            ->simplePaginate($limit);

        return $this->instance;
    }

    public function getNotStartClassroomPaginate($limit = 10)
    {

        $query = $this->getQueryBuilder()->with(['teacher']);

        $this->instance = $query->where('status',ClassroomStatus::NotStarted->value)
            ->orderBy('id', 'desc')
            ->simplePaginate($limit);

        return $this->instance;
    }

    public function getClassroomByStudentPaginate($id, $status = null, $limit = 10)
    {

        $query = $this->getQueryBuilder()->with(['teacher','sessions'])
                    ->whereHas('students', function ($q) use ($id) {
                        $q->where('students.id', $id);
                    });
        
        if($status){
            $query = $query->where('status', $status);
        }

        $this->instance = $query
            ->orderBy('id', 'desc')
            ->simplePaginate($limit);

        return $this->instance;
    }

    
    public function showClassroomByStudent($id, $studentId)
    {
        return $this->getQueryBuilder()
            ->with([
                'teacher',
                'students',
                'schedules',
                'sessions' => function ($q) use ($studentId) {
                    $q->with([
                        'attendance' => fn($q2) => $q2->where('student_id', $studentId)
                    ]);
                }
            ])
            ->whereHas('students', fn($q) => $q->where('students.id', $studentId))
            ->findOrFail($id);
    }

    
    public function getClassroomByTeacherPaginate($id, $status = null, $limit = 10)
    {

        $query = $this->getQueryBuilder()->where('teacher_id',$id);

        if($status){
            $query = $query->where('status', $status);
        }
        
        $this->instance = $query
            ->orderBy('id', 'desc')
            ->simplePaginate($limit);

        return $this->instance;
    }

    public function getAvailableClassroomByTeacherPaginate($id, $date = null, $limit = 10)
    {

        $query = $this->getQueryBuilder()->where('teacher_id',$id)->where('status',ClassroomStatus::NotStarted);


        if($date){
            $query = $query->whereHas('sessions', fn($q) => $q->where('sessions.date', $date));
        }else{
            $query = $query->whereHas('sessions', fn($q) => $q->where('sessions.date', today()));
        }
        
        $this->instance = $query
            ->orderBy('id', 'desc')
            ->simplePaginate($limit);

        return $this->instance;
    }

    public function showClassroomByTeacher($id, $teacherId)
    {
        return $this->getQueryBuilder()
            ->with([
                'teacher',
                'students',
                'schedules',
                'sessions'
            ])
            ->where('teacher_id', $teacherId)
            ->findOrFail($id);
    }

    public function searchAndFilterClassroom($id, $search = null, $filter = ClassroomFilter::All->value, $limit = 10)
    {

        $query = $this->getQueryBuilder()->with(['teacher','sessions']);

        switch ($filter) {
            case ClassroomFilter::Registered->value:
                $query = $query->whereHas('students', function ($q) use ($id) {
                        $q->where('students.id', $id);
                    });
                break;
            
            case ClassroomFilter::NotRegister->value:
                $query = $query->whereDoesntHave('students', function ($q) use ($id) {
                        $q->where('students.id', $id);
                    });
                break;
            
            default:
                break;
        }

        if ($search) {
            $query = $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhereHas('teacher', function ($q) use ($search) {
                    $q->where('fullname', 'like', "%$search%");
                });
            });
        }


        $this->instance = $query
            ->orderBy('id', 'desc')
            ->simplePaginate($limit);

        return $this->instance;
    }
}
