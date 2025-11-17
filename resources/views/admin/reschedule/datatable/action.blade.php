@if(App\Enums\Reschedule\RescheduleStatus::Pending->value == $status)
<a href="{{ route('admin.reschedule.approve', $id) }}" title="Xác nhận"><button type="button" class="btn btn-success btn-icon">
        <i class="ti ti-circle-check"></i>
</button></a>
<a href="{{ route('admin.reschedule.reject', $id) }}" title="Từ chối"><button type="button" class="btn btn-danger btn-icon">
        <i class="ti ti-circle-x"></i>
</button></a>
@endif
