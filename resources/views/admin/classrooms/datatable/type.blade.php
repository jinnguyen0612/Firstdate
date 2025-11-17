<span @class(['badge', App\Enums\Classroom\ClassroomType::from($type)->badge()])>
        {{ \App\Enums\Classroom\ClassroomType::getDescription($type) }}</span>
