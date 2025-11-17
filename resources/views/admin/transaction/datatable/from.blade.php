@if($from_type === \App\Models\User::class)
    @if(empty($from['id']) || empty($from['fullname']))
        <span>Người dùng: {{ $from_name }}</span>
    @else
        <x-link :href="route('admin.user.edit', $from['id'])" :title="$from['fullname']" />
    @endif
@elseif($from_type === \App\Models\Partner::class)
    @if(empty($from['id']) || empty($from['name']))
            <span>Đối tác: {{ $from_name }}</span>
    @else
        <x-link :href="route('admin.partner.edit', $from['id'])" :title="$from['name']" />
    @endif
@else
    <span>Hệ thống</span>
@endif
