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
                <div class="booking-name mb-2">Danh sách cuộc hẹn ngày {{ format_date($today, 'd/m/Y') }}</div>
            </div>
            @if (isset($bookings) && $bookings != null && count($bookings) > 0)
                <div class="row">

                    @foreach ($bookings as $booking)
                        <div class="booking-item col-12 col-md-6 col-lg-4" data-booking-code="{{ $booking['code'] }}"
                            data-code="{{ $code }}">
                            <div class="our-team">
                                <div class="picture">
                                    <img class="img-fluid" src="{{ asset('public/assets/svg/dinner-svgrepo-com.svg') }}">
                                </div>
                                <div class="team-content">
                                    <h3 class="name">Cuộc hẹn:</h3>
                                    <h3 class="name">#{{ $booking['code'] }}</h3>
                                    <h4 class="title">#{{ $booking['code'] }}</h4>
                                    @if ($booking['status'] == App\Enums\Booking\BookingStatus::Cancelled->value)
                                        <h4 class="title text-danger">
                                            Đã hủy
                                        </h4>
                                    @elseif($booking['status'] == App\Enums\Booking\BookingStatus::Completed->value)
                                        <h4 class="title text-danger">
                                            Đã hoàn thành
                                        </h4>
                                    @elseif($booking['status'] == App\Enums\Booking\BookingStatus::Processing->value)
                                        <h4 class="title text-danger">
                                            Đang tiến hành
                                        </h4>
                                    @elseif($booking['status'] == App\Enums\Booking\BookingStatus::Confirmed->value)
                                        <h4 class="title text-danger">
                                            Đã xác nhận
                                        </h4>
                                    @endif
                                </div>
                                <ul class="social">

                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="fw-bold text-danger fs-italic text-center">Không có cuộc hẹn trong ngày hôm nay</div>
            @endif
            <div class="text-center mt-4">
                {{-- <button type="button" id="btn-checkin" class="btn btn-default py-2 px-4">Xác nhận</button> --}}
                <a href="#" class="app-icon">
                    <img width="40px" height="40px" src="{{ asset('public/assets/svg/google-play-svgrepo-com.svg') }}"
                        alt="CH Play">
                </a>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <a href="#" class="app-icon">
                    <img width="40px" height="40px" src="{{ asset('public/assets/svg/app-store-svgrepo-com.svg') }}"
                        alt="App Store">
                </a>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const spans = document.querySelectorAll('.booking-item');

            spans.forEach(span => {
                span.addEventListener('click', () => {
                    const code = span.dataset.code;
                    const bookingCode = span.dataset.bookingCode;

                    if (!bookingCode || !code) {
                        alert('Không tìm thấy thông tin mã đặt chỗ hoặc mã bàn.');
                        return;
                    }

                    // Laravel render sẵn base url
                    const baseUrl = "{{ url('/checkin') }}";
                    const checkinUrl = `${baseUrl}/${code}/staff/${bookingCode}`;

                    window.location.href = checkinUrl;
                });
            });
        });
    </script>
@endpush
