@php use App\Enums\Notification\NotificationStatus;@endphp
@foreach ($notifications as $notification)
    <div class="card notification-card mb-3 {{ $notification->status == NotificationStatus::NOT_READ ? 'unread' : '' }}">
        <a href="{{ route('partner.notification.show', $notification->id) }}" class="d-flex flex-row">
            <div class="flex-shrink-0 text-center">
                <div class="icon-group">
                    @if ($notification->status == NotificationStatus::NOT_READ)
                        <i class="ti ti-bell-ringing"></i>
                        <span class="red-dot"></span>
                    @else
                        <i class="ti ti-bell"></i>
                    @endif
                </div>
            </div>

            <div class="mobile-card-content flex-grow-1">
                <div class="mobile-notification-title">
                    {{ $notification->title }}
                </div>
                <div class="mobile-notification-content">
                    {{ $notification->short_message }}
                </div>
                <div class="mobile-notification-time">
                    <i class="ti ti-clock"></i> {{ $notification->created_at->format('H:i d/m/Y') }}
                </div>
            </div>
        </a>
    </div>
@endforeach
