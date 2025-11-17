@if (!empty($time))
    <span>{{ format_date($date) . ' | ' . format_time($time) }}</span>
@else
    <span>{{ format_date($date) . ' | ' . format_time($deal['deal_time']['from']) . ' - ' . format_time($deal['deal_time']['to']) }}</span>
@endif
