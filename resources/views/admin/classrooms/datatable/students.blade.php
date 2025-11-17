<span class="badge {{ $is_full ? 'bg-success' : 'bg-gray' }}">
    {{ is_countable($students) ? count($students) : 0 }} / {{ $max_students }}
</span>