<span @class(['badge', App\Enums\Reschedule\RescheduleStatus::from($status)->badge()])>
        {{ \App\Enums\Reschedule\RescheduleStatus::getDescription($status) }}</span>
