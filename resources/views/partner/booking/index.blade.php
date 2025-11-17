@php use App\Enums\Booking\BookingStatus;@endphp
@extends('partner.layouts.master')
@section('title', __($title))

@push('custom-css')
    @include('partner.booking.styles.style')
    @include('partner.booking.styles.input-image')
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush

@php
    use App\Enums\User\Gender;

    if (!function_exists('genderLabel')) {
        function genderLabel($genderVal)
        {
            return match ($genderVal) {
                Gender::Male => 'Nam',
                Gender::Female => 'Nữ',
                Gender::Other => 'Khác',
                default => 'Không rõ',
            };
        }
    }

    if ($booking['data']['status'] == BookingStatus::Pending->value) {
        $title = 'Lịch hẹn mới';
        $color = 'bg-info';
        $style = '';
    } elseif ($booking['data']['status'] == BookingStatus::Confirmed->value) {
        $title = 'Đã lên lịch';
        $color = 'bg-yellow';
        $style = '';
    } elseif ($booking['data']['status'] == BookingStatus::Processing->value) {
        $title = 'Đang diễn ra';
        $color = '';
        $style = 'background-color: #F53E3E ;color: white;';
    } elseif ($booking['data']['status'] == BookingStatus::Completed->value) {
        $title = 'Đã hoàn thành';
        $color = 'bg-success';
        $style = '';
    } elseif ($booking['data']['status'] == BookingStatus::Cancelled->value) {
        $title = 'Đã huỷ';
        $color = 'bg-cancel text-black';
        $style = '';
    }
@endphp

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3 mt-md-4">
            <div class="col-12 text-center">
                <div class="mb-3">
                    <span class="badge {{ $color }} title" style="{{ $style }}">{{ $title }}</span>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex booking-code-container mb-3">
                    <span class="pe-2">Mã đặt lịch:</span>
                    <span>{{ $booking['data']['code'] }} <span class="btn btn-info btn-copy"
                            onclick="copyToClipboard('{{ $booking['data']['code'] }}')"><i
                                class="ti ti-copy"></i></span></span>
                    <input type="hidden" name="code" value="{{ $booking['data']['code'] }}">
                    <input type="hidden" name="id" value="{{ $booking['data']['id'] }}">
                </div>
            </div>

            @if ($booking['data']['status'] == BookingStatus::Pending->value)
                <div class="col-12">
                    <div class="card shadow-sm mb-3">
                        <span class="p-3 booking-time-container">Khách hàng đã chọn khung giờ <span
                                class="fw-semibold text-default">{{ format_time($booking['from'], 'H:i') }} -
                                {{ format_time($booking['to'], 'H:i') }} ngày
                                {{ format_date($booking['data']['date'], 'd/m/Y') }} </span></span>
                        @if ($booking['data']['note'])
                            <span class="p-3 booking-note-container">Ghi chú: <span
                                    class="fw-semibold text-default">{{ $booking['data']['note'] }}</span></span>
                        @endif
                        <input type="hidden" name="from" value="{{ $booking['from'] }}">
                        <input type="hidden" name="to" value="{{ $booking['to'] }}">
                    </div>
                </div>
            @elseif ($booking['data']['status'] == BookingStatus::Cancelled->value)
                <div class="col-12">
                    <div class="card shadow-sm mb-3">
                        @if ($booking['data']['time'])
                            <span class="p-3 booking-time-container">Cuộc hẹn diễn ra lúc <span
                                    class="fw-semibold text-default">{{ format_time($booking['data']['time'], 'H:i') }}
                                    ngày
                                    {{ format_date($booking['data']['date'], 'd/m/Y') }} </span></span>
                            <span class="p-3 booking-table-container">Bàn: <span
                                    class="fw-semibold text-default">{{ $booking['data']->table ? $booking['data']->table->name . ' - Mã: ' . $booking['data']->table->code : 'Chưa chọn' }}</span></span>
                        @else
                            <span class="p-3 booking-time-container">Khách hàng đã chọn khung giờ <span
                                    class="fw-semibold text-default">{{ format_time($booking['from'], 'H:i') }} -
                                    {{ format_time($booking['to'], 'H:i') }} ngày
                                    {{ format_date($booking['data']['date'], 'd/m/Y') }} </span></span>
                        @endif
                        @if ($booking['data']['note'])
                            <span class="p-3 booking-note-container">Ghi chú: <span
                                    class="fw-semibold text-default">{{ $booking['data']['note'] }}</span></span>
                        @endif
                        <input type="hidden" name="from" value="{{ $booking['from'] }}">
                        <input type="hidden" name="to" value="{{ $booking['to'] }}">
                    </div>
                </div>
            @else
                <div class="col-12">
                    <div class="card shadow-sm mb-3">
                        <span class="p-3 booking-time-container">Cuộc hẹn diễn ra lúc <span
                                class="fw-semibold text-default">{{ format_time($booking['data']['time'], 'H:i') }} ngày
                                {{ format_date($booking['data']['date'], 'd/m/Y') }} </span></span>
                        <span class="p-3 booking-table-container">Bàn: <span
                                class="fw-semibold text-default">{{ $booking['data']->table ? $booking['data']->table->name . ' - Mã: ' . $booking['data']->table->code : 'Chưa chọn' }}</span></span>
                        @if ($booking['data']['note'])
                            <span class="p-3 booking-note-container">Ghi chú: <span
                                    class="fw-semibold text-default">{{ $booking['data']['note'] }}</span></span>
                        @endif
                    </div>
                </div>
            @endif
            @if ($booking['data']['status'] == BookingStatus::Pending->value)
                <div class="col-12">
                    <div class="card shadow-sm mb-3 p-3">
                        <span class="time-title text-default fw-semibold fs-4 mb-2">Chốt giờ</span>
                        <div class="time-input-container text-center pb-3">
                            <span class="time-container">
                                <input class="time-field hour-field" type="text" name="hour" maxlength="2"
                                    placeholder="HH">
                            </span>
                            <span class="px-1 fw-semibold fs-2">:</span>
                            <span class="time-container">
                                <input class="time-field minute-field" type="text" name="minute" maxlength="2"
                                    placeholder="MM">
                            </span>
                            <input type="hidden" class="time-value" name="time-value" />
                        </div>
                        <span class="time-title text-default fw-semibold fs-4 mb-2">Chọn bàn:</span>
                        <div class="time-input-container text-center pb-3">
                            <x-select style="width: 100%;" name="partner_table_id" class="select2-bs5-ajax"
                                :data-url="route('admin.search.select.partner_table', [
                                    'partner_id' => $booking['data']['partner_id'],
                                ])" id="partner_table_id">
                            </x-select>
                        </div>

                    </div>
                </div>
            @endif
            @if ($booking['data']['status'] == BookingStatus::Processing->value)
                <div class="col-12 mb-3">
                    <div class="card shadow-sm mb-3 p-3">
                        <span class="time-title text-default fw-semibold fs-4 mb-2 text-start">Chi phí cuộc hẹn</span>
                        <div class="input-container mb-3">
                            <input type="text" class="form-control currency-input" name="total" :value="old('total')"
                                placeholder="{{ __('Chi phí cuộc hẹn') }}">
                        </div>
                        <div class="content">
                            <span class="fw-semibold">Phí:</span>
                            <span class="fw-semibold ms-1">
                                {{ $settings->where('setting_key', 'profit_split')->pluck('plain_value')->first() }}%
                            </span>
                            <br>
                            <span class="fw-semibold">Phí hệ thống:</span>
                            <span class="fw-semibold ms-1 system-fee" id="profit-display">
                            </span>
                            <span class="fw-semibold ms-1">đ</span>

                        </div>
                        <div class="bill-image">
                            <label class="picture" for="picture__input" tabIndex="0">
                                <span class="picture__image"></span>
                            </label>
                            <input type="file" name="invoice" id="picture__input">
                        </div>
                    </div>
                </div>
            @endif
            @if ($booking['data']['status'] == BookingStatus::Completed->value && $booking['data']->invoice())
                <div class="col-12 mb-3">
                    <div class="card shadow-sm mb-3 p-3">
                        <span class="time-title text-default fw-semibold fs-4 mb-2 text-start">Tổng hóa đơn:
                            {{ format_price($booking['data']['invoice']['total']) }}</span>
                        <div class="content mb-3">
                            <span class="fw-semibold">Phí hệ thống:
                                {{ format_price($booking['data']['invoice']['profit_split']) }}</span>
                        </div>
                        <div class="invoice-image">
                            <img class="img-fluid" onclick="showFullImage(this)"
                                src="{{ asset($booking['data']['invoice']['invoice']) }}" alt="">
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-12">
                <div class="d-flex justify-content-around align-items-center mb-3">
                    <div class="card user-card">
                        <a href="#">
                            <div class="image-container">
                                @if (in_array(
                                        $booking['data']['user_male']['id'],
                                        collect($booking['data']['deal']['dealCancellation'])->pluck('canceled_by')->toArray()))
                                    <span class="badge user-cancel">Người hủy hẹn</span>
                                @endif
                                <img class="card-img-top" src="{{ asset($booking['data']['user_male']['avatar']) }}"
                                    alt="user_male_avatar">
                                <span class="badge user-age">{{ $booking['data']['user_male']->age() }} tuổi</span>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="fs-6">{{ $booking['data']['user_male']['fullname'] }}</h5>
                            </div>
                        </a>
                    </div>

                    <div class="card user-card">
                        <a href="#">
                            <div class="image-container">
                                @if (in_array(
                                        $booking['data']['user_female']['id'],
                                        collect($booking['data']['deal']['dealCancellation'])->pluck('canceled_by')->toArray()))
                                    <span class="badge user-cancel">Người hủy hẹn</span>
                                @endif
                                <img class="card-img-top" src="{{ asset($booking['data']['user_female']['avatar']) }}"
                                    alt="user_male_avatar">
                                <span class="badge user-age">{{ $booking['data']['user_female']->age() }} tuổi</span>

                            </div>
                            <div class="card-body text-center">
                                <h5 class="fs-6">{{ $booking['data']['user_female']['fullname'] }}
                                </h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Từ chối cuộc hẹn -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="rejectModalLabel">Từ chối cuộc hẹn</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        Bạn có đồng ý từ chối cuộc hẹn này?
                        <input type="hidden" name="id" value="">
                    </div>
                    <div class="input-container mb-3">
                        <label class="form-label">Lí do từ chối</label>
                        {{-- <input name="note" type="text" class="form-control" placeholder="Lí do từ chối"> --}}
                        @foreach ($rejectReason as $reason)
                            <div class="mb-2">
                                <input class="radio-group" type="radio" name="reason" id="reason{{ $reason->id }}"
                                    value="{{ $reason->reason }}">
                                <label class="form-check-label" for="reason{{ $reason->id }}">
                                    {{ $reason->reason }}
                                </label>
                            </div>
                        @endforeach
                        <div class="mb-2">
                            <input class="radio-group" type="radio" name="reason" id="reasonDifferent"
                                value="">
                            <label class="form-check-label" for="reasonDifferent">
                                Khác
                            </label>
                        </div>
                        <input name="note" type="hidden" class="form-control" placeholder="Lí do từ chối">
                    </div>
                </div>
                <div class="modal-footer align-items-center justify-content-around">
                    <button type="button" class="btn text-default rounded py-2 px-4"
                        data-bs-dismiss="modal">Hủy</button>
                    <button id="btn-accept-reject" type="button" class="btn btn-default rounded py-2 px-4">Đồng
                        ý</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Hủy cuộc hẹn-->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="cancelModalLabel">Hủy cuộc hẹn</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <span class="fs-5">
                            Chọn người vắng mặt
                        </span>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3 align-self-center">
                            <span class="avatar"
                                style="background-image: url({{ asset($booking['data']['user_male']['avatar']) }})"></span>
                        </div>
                        <div class="col-7">
                            <span class="name">{{ $booking['data']['user_male']['fullname'] }}</span><br>
                            <span class="age">{{ $booking['data']['user_male']->age() }} tuổi -
                                {{ genderLabel($booking['data']['user_male']['gender']) }}</span>
                        </div>
                        <div class="col-2">
                            <div class="container">
                                <div class="round">
                                    <input name="checkbox[]" type="checkbox" id="checkbox-male"
                                        value="{{ $booking['data']['user_male']['id'] . '|' . $booking['data']['user_male']['fullname'] }}" />
                                    <label for="checkbox-male"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 align-self-center">
                            <span class="avatar"
                                style="background-image: url({{ asset($booking['data']['user_female']['avatar']) }})"></span>
                        </div>
                        <div class="col-7">
                            <span class="name">{{ $booking['data']['user_female']['fullname'] }}</span><br>
                            <span class="age">{{ $booking['data']['user_female']->age() }} tuổi -
                                {{ genderLabel($booking['data']['user_female']['gender']) }}</span>
                        </div>
                        <div class="col-2">
                            <div class="container">
                                <div class="round">
                                    <input name="checkbox[]" type="checkbox" id="checkbox-female"
                                        value="{{ $booking['data']['user_female']['id'] . '|' . $booking['data']['user_female']['fullname'] }}" />
                                    <label for="checkbox-female"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer align-items-center justify-content-around">
                    <button id="btn-accept-cancel" type="button" class="btn btn-default rounded py-2 px-4 w-100">Xác
                        nhận hủy</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal xác nhận hủy-->
    <div class="modal fade" id="confirmCancelModal" tabindex="-1" aria-labelledby="confirmCancelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="confirmCancelModalLabel">Hủy cuộc hẹn</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3" id="confirmCancelContent">

                    </div>
                    <div class="input-container mb-3">
                        <input name="reason" type="text" class="form-control" placeholder="Lí do từ chối">
                    </div>
                </div>
                <div class="modal-footer align-items-center justify-content-around">
                    <button type="button" class="btn text-default rounded py-2 px-4"
                        data-bs-dismiss="modal">Hủy</button>
                    <button id="btn-accept-confirm-cancel" type="button" class="btn btn-default rounded py-2 px-4">Đồng
                        ý hủy</button>
                </div>
            </div>
        </div>
    </div>
    @if (
        $booking['data']['status'] != BookingStatus::Cancelled->value &&
            $booking['data']['status'] != BookingStatus::Completed->value)
        <div class="btn-container">
            @if ($booking['data']['status'] == BookingStatus::Pending->value)
                <div class="text-center btn-action">
                    <button type="button" id="btn-accept" class="btn btn-default">Chốt</button>
                </div>
                <div class="text-center btn-action">
                    <button class="btn btn-reject" type="button" data-bs-toggle="modal"
                        data-bs-target="#rejectModal">Từ
                        chối</button>
                </div>
            @elseif ($booking['data']['status'] == BookingStatus::Confirmed->value)
                <div class="text-center btn-action single-btn">
                    <span class="btn btn-default">Đã xác nhận</span>
                </div>
            @elseif ($booking['data']['status'] == BookingStatus::Processing->value)
                <div class="text-center btn-action single-btn">
                    <span class="btn btn-default">Đang tiến hành</span>
                </div>
            @endif

        </div>
    @endif

@endsection

@push('libs-js')
    <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/i18n/' . trans()->getLocale() . '.js') }}"></script>
@endpush

@push('custom-js')
    <script>
        select2LoadData($('#partner_table_id').data('url'), '#partner_table_id');
    </script>
    @include('partner.booking.scripts.api')
    @include('partner.booking.scripts.scripts')
    @include('partner.booking.scripts.accept-reject')
    @include('partner.booking.scripts.format-currency')
    @include('partner.booking.scripts.input-image')
    @include('partner.home.scripts.radio-group')
@endpush
