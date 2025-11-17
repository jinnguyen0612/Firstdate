@if($to_type === \App\Models\User::class)
    @if(empty($to['id']) || empty($to['fullname']))
        <span>Người dùng: {{ $to_name }}</span>
    @else
        <x-link :href="route('admin.user.edit', $to['id'])" :title="$to['fullname']" />
    @endif
@elseif($to_type === \App\Models\Partner::class)
    @if(empty($to['id']) || empty($to['name']))
            <span>Đối tác: {{ $to_name }}</span>
    @else
        <x-link :href="route('admin.partner.edit', $to['id'])" :title="$to['name']" />
    @endif
@else
    <span>Hệ thống</span>
@endif
