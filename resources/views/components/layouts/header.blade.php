<link rel="stylesheet" href="{{ asset('partner/assets/css/header/header.css') }}">
@php
    use App\Enums\Notification\NotificationStatus;
    use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
    $currentUser = auth('admin')->user();
    $notificationRepo = app(NotificationRepositoryInterface::class);
    if($currentUser){
        $notifications = $notificationRepo->getUnreadByPartnerId($currentUser->id);
        $count = $notifications->count();
    } else {
        $notifications = [];
        $count = 0;
    }
@endphp
<nav class="navbar navbar-expand-lg bg-body-tertiary shadow fixed-top">
    <div class="container-fluid">
        @if ($currentUser)
            <a class="navbar-brand" href="{{ route('partner.home.index') }}">
                <span class="account-avatar" style="background-image: url({{ asset($currentUser->avatar??'assets/images/anhthumb.jpg') }})"></span>
                <span class="account-name sm-display-custom">{{ $currentUser->fullname }}</span>
            </a>
        @else
            <a class="navbar-brand" href="{{ route('partner.login') }}">
                <span class="account-avatar"
                    style="background-image: url({{ asset('assets/images/anhthumb.jpg') }})"></span>
                <span class="account-name">Chưa đăng nhập</span>
            </a>
        @endif
        <!-- Mobile -->
        <div class="d-flex align-items-center justify-content-end gap-2">
            <span class="navbar-text d-lg-none">
                <span class="notification-container dropdown">
                    @if ($currentUser)
                        <a class="notification-button py-2 px-1" href="{{ route('partner.notification.index') }}">
                            <i class="ti ti-bell me-2" style="font-size: 1.5rem;"></i>
                            <span class="badge bg-red notification-badge counter">{{ $count }}</span>
                        </a>
                    @else
                        <a class="notification-button py-2 px-1" href="{{ route('partner.notification.index') }}">
                            <i class="ti ti-bell me-2" style="font-size: 1.5rem;"></i>
                            <span class="badge bg-red notification-badge counter">0</span>
                        </a>
                    @endif
                </span>
            </span>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <!-- Desktop -->
        <div class="collapse navbar-collapse d-none d-lg-block" id="navbarText">
            <ul class="navbar-nav m-auto mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'partner.home.index' ? 'active' :'' }}" aria-current="page" href="{{ route('partner.home.index') }}">Trang
                        chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'partner.profile.index' ? 'active' :'' }}" href="{{ route('partner.profile.index') }}">Tài khoản</a>
                </li>
            </ul>
            <span class="navbar-text d-none d-lg-block">
                <span class="notification-container dropdown">
                    <button class="dropdown-toggle notification-button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ti ti-bell me-2" style="font-size: 1.5rem;"></i>
                        <span class="badge bg-red notification-badge counter">{{ $count }}</span>
                        <span class="fw-semibold" style="font-size: 1.2rem">Thông báo</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end notification-list">
                        <li class="notification-header fw-semibold">
                            Thông báo <span style="border-radius: 50%; font-size: 1rem"
                                class="p-2 badge bg-white text-default fw-semibold">{{ $count }}</span>
                        </li>
                        <div class="notification-body">
                            @if ($count > 0)
                                @foreach ($notifications as $notification)
                                    <li><a class="dropdown-item" href="{{ route('partner.notification.show', $notification->id) }}">
                                            <div class="list-group-item d-flex align-items-center">
                                                <div class="flex-shrink-0 rounded-circle m-1 me-2 bg-primary d-flex align-items-center justify-content-center"
                                                    style="width: 34px; height: 34px">
                                                    <i class="ti ti-bell text-white" style="font-size: 1.2rem"></i>
                                                </div>
                                                <div class="flex-wrap flex-grow-1">
                                                    <span class="fs-6 fw-semibold text-wrap">{{ $notification->title }}</span>
                                                    <br>
                                                    <span class="text-muted small time-diff" data-time="{{ $notification->created_at->toIso8601String() }}"></span>
                                                </div>
                                            </div>
                                        </a></li>
                                @endforeach
                            @else
                                <li>
                                    <div class="list-group-item text-center d-flex align-items-center justify-content-center"
                                        style="height: 80px">
                                        <span class="fst-italic">Không có thông báo mới</span>
                                    </div>
                                </li>
                            @endif
                        </div>
                        <li><a href="{{ route('partner.notification.index') }}">
                                <div class="notification-footer">
                                    <span class="fw-semibold">Tất cả thông báo</span>
                                </div>
                            </a></li>
                    </ul>
                </span>
            </span>
        </div>

        <div class="offcanvas offcanvas-start d-lg-none d-block" data-bs-scroll="true" tabindex="-1"
            id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            @if ($currentUser)
                <a class="navbar-brand" href="{{ route('partner.home.index') }}">
                    <span class="account-avatar"
                        style="background-image: url({{ asset($currentUser->avatar??'assets/images/anhthumb.jpg') }})"></span>
                    <span class="account-name">{{ $currentUser->fullname }}</span>
                </a>
            @else
                <a class="navbar-brand" href="{{ route('partner.login') }}">
                    <span class="account-avatar"
                        style="background-image: url({{ asset('assets/images/anhthumb.jpg') }})"></span>
                    <span class="account-name">Chưa đăng nhập</span>
                </a>
            @endif
            <hr>
            <ul class="navbar-nav ms-auto me-auto mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'partner.home.index' ? 'active' :'' }}" aria-current="page" href="{{ route('partner.home.index') }}"><i
                            class="ti ti-home me-2"></i> Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'partner.profile.index' ? 'active' :'' }}" aria-current="page" href="{{ route('partner.profile.index') }}">
                        <ti class="ti ti-user me-2"></ti> Tài khoản
                    </a>
                </li>
            </ul>
            @if ($currentUser)
                <hr>
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <a href="{{ route('partner.logout') }}" class="btn btn-default px-4"><span>Đăng xuất</span></a>
                </div>
            @endif
        </div>
    </div>
</nav>


@push('libs-js')
@endpush

@push('custom-js')
    <script>
        $(document).ready(function() {
            $('.counter').each(function() {
                let $this = $(this);
                let target = parseInt($this.text());

                if (target > 9) {
                    // Đếm đến 9, sau đó hiện "9+"
                    $this.prop('Counter', 0).animate({
                        Counter: 9
                    }, {
                        duration: 1500,
                        easing: 'swing',
                        step: function(now) {
                            $this.text(Math.ceil(now));
                        },
                        complete: function() {
                            $this.text('9+');
                        }
                    });
                } else {
                    // Đếm bình thường đến target
                    $this.prop('Counter', 0).animate({
                        Counter: target
                    }, {
                        duration: 1500,
                        easing: 'swing',
                        step: function(now) {
                            $this.text(Math.ceil(now));
                        }
                    });
                }
            });
        });
    </script>
    <script src="{{ asset('partner/assets/js/header/header.js') }}"></script>
@endpush
