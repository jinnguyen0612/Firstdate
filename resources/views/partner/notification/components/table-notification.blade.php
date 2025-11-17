@php
    use App\Enums\Notification\NotificationStatus;
    $first = $notifications->total() == 0 ? 0 : ($notifications->currentPage() * $notifications->perPage() - $notifications->perPage() + 1);
    $last =
        $notifications->currentPage() * $notifications->perPage() > $notifications->total()
            ? $notifications->total()
            : $notifications->currentPage() * $notifications->perPage();
@endphp
<div class="table-container">
    <div class="mail-option">
        <div class="chk-all">
            <input type="checkbox" class="mail-checkbox mail-group-checkbox">
        </div>

        <div class="btn-group">
            <button type="button" id="btn-read" class="btn btn-success me-2 rounded" data-bs-toggle="tooltip" data-bs-placement="top"
                title="Đánh dấu đã đọc">
                <i class="fas fa-envelope-open"></i>
            </button>
            <button type="button" id="btn-delete" class="btn btn-danger me-2 rounded" data-bs-toggle="tooltip" data-bs-placement="top" title="Xóa">
                <i class="fas fa-trash"></i>
            </button>
        </div>

        <ul class="unstyled inbox-pagination">
            <li><span>{{ $first }} - {{ $last }} của {{ $notifications->total() }} thông báo</span></li>
            <li>
                <button id="btn-previous" class="btn np-btn pagination-link border" {{$notifications->currentPage() == 1 ? 'disabled' : ''}}>
                    <i class="fa fa-angle-left pagination-left"></i>
                </button>
            </li>
            <li>
                <button id="btn-next" class="btn np-btn pagination-link border" {{$notifications->currentPage() == $notifications->lastPage() ? 'disabled' : ''}}>
                    <i class="fa fa-angle-right pagination-right"></i>
                </button>
            </li>
        </ul>
    </div>

    <div class="table-content-wrapper">
        <table class="table table-inbox table-hover table-responsive">
            <tbody>
                @foreach ($notifications as $notification)
                    <tr onclick="openNotification('{{ route('partner.notification.show', ['id' => $notification->id]) }}')" class="{{ $notification->status == NotificationStatus::NOT_READ ? 'unread' : '' }}">
                        <td class="inbox-small-cells">
                            <input type="checkbox" class="mail-checkbox" value="{{ $notification->id }}" onclick="event.stopPropagation()">
                        </td>
                        <td class="view-message  inbox-title">{{ $notification->title }}</td>
                        <td class="view-message inbox-message">{{ $notification->short_message }}</td>
                        <td class="view-message inbox-datetime  text-end time-diff"
                            data-time="{{ $notification->created_at->toIso8601String() }}"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('custom-js')
    <script>
        function openNotification(route){
            window.location.href = route
        }
    </script>
@endpush