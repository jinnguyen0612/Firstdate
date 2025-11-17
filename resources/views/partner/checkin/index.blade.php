@extends('partner.layouts.guest')

@section('title', $title)

@push('libs-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@push('custom-css')
    @include('partner.checkin.styles.style')
    @include('partner.checkin.styles.card')
@endpush

@section('content')
    <div class="container mb-3">
        <div class="card shadow-sm p-4">
            <div class="title">
                <div class="app-name"><span class="logo"></span> <span style="margin-top: 10px">FirstDate</span></div>
                <div class="table-name">Bàn #{{ $code }}</div>
            </div>
            <div class="row">
                @if (isset($booking))
                    <div class="user-checkin col-12 col-md-6 col-lg-4"
                        data-user-code="{{ $booking['user_female']['code'] }}" data-booking-code="{{ $booking['code'] }}">
                        <div class="our-team">
                            <div class="picture"
                                style="--after-bg:{{ $booking->hasUserAttended($booking['user_female_id']) ? '#00FF00' : '#FF0000' }};">
                                @if ($booking['user_female']['gender'] == App\Enums\User\Gender::Female->value)
                                    <img class="img-fluid" src="{{ asset('/assets/images/default/avatar-girl.png') }}"
                                        alt="avatar-female" />
                                @elseif($booking['user_female']['gender'] == App\Enums\User\Gender::Male->value)
                                    <img class="img-fluid" src="{{ asset('/assets/images/default/avatar-boy.png') }}"
                                        alt="avatar-female" />
                                @else
                                    <img class="img-fluid" src="{{ asset('/assets/images/default/avatar-unknown.png') }}"
                                        alt="avatar-female" />
                                @endif
                            </div>
                            <div class="team-content">
                                <h3 class="name">{{ $booking['user_female']['fullname'] }}</h3>
                                <h4 class="title">#{{ $booking['code'] }}</h4>
                                @if ($booking->hasUserAttended($booking['user_female_id']))
                                    <h4 class="title text-success">
                                        Đã đến
                                    </h4>
                                @else
                                    <h4 class="title text-danger">
                                        Chưa đến
                                    </h4>
                                @endif
                            </div>
                            <ul class="social">

                            </ul>
                        </div>
                    </div>

                    <div class="user-checkin col-12 col-md-6 col-lg-4" data-user-code="{{ $booking['user_male']['code'] }}"
                        data-booking-code="{{ $booking['code'] }}">
                        <div class="our-team">
                            <div class="picture"
                                style="--after-bg:{{ $booking->hasUserAttended($booking['user_male_id']) ? '#00FF00' : '#FF0000' }};">
                                @if ($booking['user_male']['gender'] == App\Enums\User\Gender::Female->value)
                                    <img class="img-fluid" src="{{ asset('/assets/images/default/avatar-girl.png') }}"
                                        alt="avatar-male" />
                                @elseif($booking['user_male']['gender'] == App\Enums\User\Gender::Male->value)
                                    <img class="img-fluid" src="{{ asset('/assets/images/default/avatar-boy.png') }}"
                                        alt="avatar-male" />
                                @else
                                    <img class="img-fluid" src="{{ asset('/assets/images/default/avatar-unknown.png') }}"
                                        alt="avatar-male" />
                                @endif
                            </div>
                            <div class="team-content">
                                <h3 class="name">{{ $booking['user_male']['fullname'] }}</h3>
                                <h4 class="title">#{{ $booking['code'] }}</h4>
                                @if ($booking->hasUserAttended($booking['user_male_id']))
                                    <h4 class="title text-success">
                                        Đã đến
                                    </h4>
                                @else
                                    <h4 class="title text-danger">
                                        Chưa đến
                                    </h4>
                                @endif
                            </div>
                            <ul class="social">

                            </ul>
                        </div>
                    </div>
                @endif

                <div class="staff-checkin col-12 col-md-6 col-lg-4" data-code="{{ $code }}">
                    <div class="our-team">
                        <div class="picture">
                            <img class="img-fluid" src="{{ asset('/assets/svg/waiter-svgrepo-com.svg') }}">
                        </div>
                        <div class="team-content">
                            <h3 class="name">Nhân viên</h3>
                            <br>
                            <br>
                        </div>
                        <ul class="social">

                        </ul>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                {{-- <button type="button" id="btn-checkin" class="btn btn-default py-2 px-4">Xác nhận</button> --}}
                <!-- App Store button -->
                <a href=""><img
                        src="https://developer.apple.com/app-store/marketing/guidelines/images/badge-example-preferred.png"
                        width="132" height="40" alt="Download on the App Store" border="0"></a>
                <a href=""><img
                        src="https://play.google.com/intl/en_us/badges/images/generic/en_badge_web_generic.png"
                        width="150" height="60" alt="Get it on Google Play" border="0"></a>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- USER CHECKIN ---
            document.querySelectorAll('.user-checkin').forEach(item => {
                item.addEventListener('click', () => {
                    const userCode = item.dataset.userCode;
                    const bookingCode = item.dataset.bookingCode;

                    if (!userCode || !bookingCode) {
                        alert('Không tìm thấy thông tin người dùng hoặc mã đặt chỗ.');
                        return;
                    }

                    const baseUrl = "{{ url('/checkin') }}";
                    window.location.href = `${baseUrl}/${bookingCode}/${userCode}`;
                });
            });

            // --- STAFF CHECKIN ---
            document.querySelectorAll('.staff-checkin').forEach(item => {
                item.addEventListener('click', () => {
                    const code = item.dataset.code;
                    if (!code) {
                        alert('Không tìm thấy mã bàn.');
                        return;
                    }

                    const baseUrl = "{{ url('/checkin') }}";
                    window.location.href = `${baseUrl}/${code}/staff`;
                });
            });
        });
    </script>
@endpush
