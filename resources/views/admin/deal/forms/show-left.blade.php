<div class="card m-3">
    <div @class([
        'ribbon ribbon-bottom fs-5',
        App\Enums\Deal\DealStatus::from($deal->status)->badge(),
    ])>{{ \App\Enums\Deal\DealStatus::getDescription($deal->status) }}</div>
    <div class="row py-3 pr-2">
        <div class="col-12 col-md-6 user-info mb-3">
            <span class="badge bg-primary mb-2 user-info-title">Người lên buổi hẹn</span> <br>
            <span class="fs-3 mb-2">Họ và tên: <strong><a
                        href="{{ route('admin.user.edit', $deal->user_female['id']) }}">{{ $deal->user_female['fullname'] }}</a></strong></span>
            -
            <span class="fs-3"><strong>{{ $deal->user_female->age() }}</strong> tuổi</span> <br>
            <span class="fs-3 mb-2">Địa chỉ: <strong>{{ $deal->user_female->district->name }},
                    {{ $deal->user_female->province->name }}</strong></span><br>
            <span class="fs-3 mb-2">Mối quan hệ tìm kiếm:</span>
            @foreach ($deal->user_female->userRelationship as $item)
                <span @class([
                    'status mb-1',
                    'status-' . App\Enums\User\Relationship::from($item->relationship)->color(),
                ])>
                    <span class="status-dot status-dot-animated"></span>
                    {{ App\Enums\User\Relationship::getDescription($item->relationship) }}
                </span>
            @endforeach
            <br>
            <span class="fs-3 mb-2">Thời gian hẹn hò:</span>
            @foreach ($deal->user_female->userDatingTimes as $item)
                <span @class([
                    'status mb-1',
                    'status-' . App\Enums\User\DatingTime::from($item->dating_time)->color(),
                ])>
                    <span class="status-dot"></span>
                    {{ App\Enums\User\DatingTime::getDescription($item->dating_time) }}
                </span>
            @endforeach
        </div>
        <div class="col-md-6 col-12 user-info mb-3">
            <span class="badge bg-success mb-2 user-info-title">Người chốt buổi hẹn</span> <br>
            <span class="fs-3 mb-2">Họ và tên: <strong><a
                        href="{{ route('admin.user.edit', $deal->user_male['id']) }}">{{ $deal->user_male['fullname'] }}</a></strong></span>
            -
            <span class="fs-3"><strong>{{ $deal->user_male->age() }}</strong> tuổi</span> <br>
            <span class="fs-3 mb-2">Địa chỉ: <strong>{{ $deal->user_male->district->name }},
                    {{ $deal->user_male->province->name }}</strong></span> <br>
            <span class="fs-3 mb-2">Mối quan hệ tìm kiếm:</span>
            @foreach ($deal->user_male->userRelationship as $item)
                <span @class([
                    'status mb-1',
                    'status-' . App\Enums\User\Relationship::from($item->relationship)->color(),
                ])>
                    <span class="status-dot status-dot-animated"></span>
                    {{ App\Enums\User\Relationship::getDescription($item->relationship) }}
                </span>
            @endforeach
            <br>
            <span class="fs-3 mb-2">Thời gian hẹn hò:</span>
            @foreach ($deal->user_male->userDatingTimes as $item)
                <span @class([
                    'status mb-1',
                    'status-' . App\Enums\User\DatingTime::from($item->dating_time)->color(),
                ])>
                    <span class="status-dot"></span>
                    {{ App\Enums\User\DatingTime::getDescription($item->dating_time) }}
                </span>
            @endforeach
        </div>
    </div>
</div>
<div class="card m-3">
    <div class="swiper-container-wrapper swiper-container-wrapper--timeline">
        <!-- Custom Pagination -->
        <ul class="swiper-pagination-custom">
            <li class="swiper-pagination-switch active">
                <i class="ti ti-map-2 fw-medium"></i>
                <span class="switch-title fw-medium fs-3 title-can-hide">Chọn Quận</span>
            </li>
            <li @class([
                'swiper-pagination-switch',
                $deal->dealPartnerOptions->isEmpty() ? 'disabled' : '',
            ])>
                <i class="ti ti-building-store fw-medium"></i>
                <span class="switch-title fw-medium fs-3 title-can-hide">Chọn Quán</span>
            </li>
            <li @class([
                'swiper-pagination-switch',
                $deal->dealPartnerOptions->isEmpty() || $deal->dealDateOptions->isEmpty()
                    ? 'disabled'
                    : '',
            ])>
                <i class="ti ti-clock fw-medium"></i>
                <span class="switch-title fw-medium fs-3 title-can-hide">Chọn Thời gian</span>
            </li>
            <li @class([
                'swiper-pagination-switch',
                $deal->dealPartnerOptions->isEmpty() || $deal->dealDateOptions->isEmpty()
                    ? 'disabled'
                    : '',
            ])>
                <i class="ti ti-cash-banknote fw-medium"></i>
                <span class="switch-title fw-medium fs-3 title-can-hide">Cọc tiền</span>
            </li>
        </ul>

        <!-- Progressbar -->
        <div class="swiper-pagination swiper-pagination-progressbar swiper-pagination-horizontal"></div>

        <!-- Swiper -->
        <div class="swiper swiper-container swiper-container--timeline">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <h2 class="mt-5 mb-3 fw-bold">Thông tin Quận đã chọn</h2><br>
                    <div class="row g-3">
                        @if ($deal->dealDistrictOptions->isEmpty())
                            <div class="d-flex justify-content-center align-items-center">
                                <span class="fs-3 text-danger fst-italic">Người dùng chưa chọn quận</span>
                            </div>
                        @else
                            @foreach ($deal->dealDistrictOptions as $item)
                                <div class="col-6 col-md-4">
                                    <label class="district-card">
                                        <input type="checkbox" disabled value="{{ $item->id }}" hidden
                                            {{ $item->is_chosen == 1 ? 'checked' : '' }}>
                                        <div class="district-card-body">
                                            <i class="ti ti-map-pin"></i>
                                            <span>{{ $item->district->name }}</span>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div @class(['swiper-slide'])>
                    <h2 class="mt-5 mb-3 fw-bold">Thông tin Quán đã chọn</h2><br>
                    <div class="row g-3">
                        @if ($deal->dealPartnerOptions->isEmpty())
                            <div class="d-flex justify-content-center align-items-center">
                                <span class="fs-3 text-danger fst-italic">Người dùng chưa chọn quán</span>
                            </div>
                        @else
                            @foreach ($deal->dealPartnerOptions as $item)
                                <div class="col-6 col-md-4">
                                    <label class="district-card">
                                        <input type="checkbox" disabled value="{{ $item->id }}" hidden
                                            {{ $item->is_chosen == 1 ? 'checked' : '' }}>
                                        <div class="district-card-body">
                                            <i class="ti ti-map-pin"></i>
                                            <span>{{ $item->partner->name }}</span>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div @class(['swiper-slide'])>
                    <h2 class="mt-5 mb-3 fw-bold">Thông tin thời gian đã chọn</h2><br>
                    <div class="row g-3">
                        @if ($deal->dealDateOptions->isEmpty())
                            <div class="d-flex justify-content-center align-items-center">
                                <span class="fs-3 text-danger fst-italic">Người dùng chưa chọn quán</span>
                            </div>
                        @else
                            @foreach ($deal->dealDateOptions as $item)
                                <div class="col-6 col-md-4">
                                    <label class="district-card readonly">
                                        <input type="checkbox" disabled value="{{ $item->id }}" hidden
                                            {{ $item->is_chosen == 1 ? 'checked' : '' }}>
                                        <div class="district-card-body d-flex">
                                            <i class="ti ti-map-pin me-2"></i>
                                            <div class="d-flex flex-column flex-md-row gap-1">
                                                <span>{{ format_date($item->date, 'd-m-Y') }}</span>
                                                <hr class="my-1 d-block d-md-none"
                                                    style="border-top: 2px solid #000000; width: 100%;" />
                                                <span class="d-none d-md-inline">|</span>
                                                <span>{{ format_time($item->from, 'H:i') }} -
                                                    {{ format_time($item->to, 'H:i') }}</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div @class(['swiper-slide'])>
                    <h2 class="mt-5 mb-3 fw-bold">Thông tin cọc tiền</h2><br>
                    <div class="row g-3">
                        @if (!$booking)
                            <div class="d-flex justify-content-center align-items-center">
                                <span class="fs-3 text-danger fst-italic">Dịch vụ chưa được đặt</span>
                            </div>
                        @else
                            <div class="col-6 px-5">
                                <span class="fs-3">
                                    <x-link :href="route('admin.user.edit', $booking->user_female_id)" :title="$booking->user_female['fullname']" /> <br>
                                </span>
                                @if ($booking->depositForUser($booking->user_female_id) == 0)
                                    <span class="fs-3">Chưa gửi tiền cọc</span>
                                @else
                                    <span class="fs-3">Số tiền cọc:
                                        {{ format_point($booking->depositForUser($booking->user_female_id)) }}
                                        tim</span>
                                @endif
                            </div>
                            <div class="col-6 px-5">
                                <span class="fs-3">
                                    <x-link :href="route('admin.user.edit', $booking->user_male_id)" :title="$booking->user_male['fullname']" /> <br>
                                </span>
                                @if ($booking->depositForUser($booking->user_male_id) == 0)
                                    <span class="fs-3">Chưa gửi tiền cọc</span>
                                @else
                                    <span class="fs-3">Số tiền cọc:
                                        {{ format_point($booking->depositForUser($booking->user_male_id)) }} tim</span>
                                @endif
                            </div>
                            <div class="col-12 px-5 mt-6 text-center">
                                <a class="btn btn-success" href="{{ route('admin.booking.show', $booking->id) }}">
                                    Thông tin đặt dịch vụ
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
