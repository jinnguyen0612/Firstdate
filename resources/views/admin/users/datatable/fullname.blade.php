@if ($fullname !== null)
<x-link :href="route('admin.user.edit', $id)" :title="$fullname" /><br>
@endif
