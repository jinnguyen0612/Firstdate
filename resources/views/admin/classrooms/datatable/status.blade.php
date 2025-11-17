<span @class(['badge', App\Enums\Classroom\ClassroomStatus::from($status)->badge()])>
        {{ \App\Enums\Classroom\ClassroomStatus::getDescription($status) }}</span>
