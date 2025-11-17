@extends('partner.layouts.guest')

@section('title', $title)

@push('libs-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@push('custom-css')
    @include('partner.checkin.styles.style')
    @include('partner.checkin.styles.input-image')
    @include('partner.checkin.styles.card')
@endpush

@section('content')
    @php use App\Enums\Booking\BookingStatus;@endphp
    <div class="container mb-3">
        <div class="card shadow-sm p-4">
            <div class="title">
                <div class="app-name"><span class="logo"></span> <span style="margin-top: 10px">FirstDate</span></div>
                <div class="table-name">Bàn #{{ $code }}</div>
                <div class="booking-name mb-2">Thông tin cuộc hẹn #{{ $booking['code'] }}</div>
                <input type="hidden" name="id" value="{{ $booking['id'] }}">
            </div>
            @if (isset($booking) && $booking != null)
                @if ($booking['status'] == BookingStatus::Processing->value)
                    <div class="col-12 mb-3">
                        <div class="card shadow-sm mb-3 p-3">
                            <span class="time-title text-default fw-semibold fs-4 mb-2 text-start">Chi phí cuộc hẹn</span>
                            <div class="input-container mb-3">
                                <input type="text" class="form-control currency-input" name="total"
                                    :value="old('total')" placeholder="{{ __('Chi phí cuộc hẹn') }}">
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
                @if ($booking['status'] == BookingStatus::Completed->value && $booking->invoice())
                    <div class="col-12 mb-3">
                        <div class="card shadow-sm mb-3 p-3">
                            <span class="time-title text-default fw-semibold fs-4 mb-2 text-start">Tổng hóa đơn:
                                {{ format_price($booking['invoice']['total']) }}</span>
                            <div class="content mb-3">
                                <span class="fw-semibold">Phí hệ thống:
                                    {{ format_price($booking['invoice']['profit_split']) }}</span>
                            </div>
                            <div class="invoice-image">
                                <img class="img-fluid" onclick="showFullImage(this)"
                                    src="{{ asset($booking['invoice']['invoice']) }}" alt="">
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-12">
                    <div class="row">
                        <div class="col-6 col-md-5">
                            <a href="#">
                                <div class="our-team">
                                    <div class="picture"
                                        style="--after-bg:{{ $booking->hasUserAttended($booking['user_female_id']) ? '#00FF00' : '#FF0000' }};">
                                        @if ($booking['user_female']['gender'] == App\Enums\User\Gender::Female->value)
                                            <img class="img-fluid"
                                                src="{{ asset('/assets/images/default/avatar-girl.png') }}"
                                                alt="avatar-female" />
                                        @elseif($booking['user_female']['gender'] == App\Enums\User\Gender::Male->value)
                                            <img class="img-fluid"
                                                src="{{ asset('/assets/images/default/avatar-boy.png') }}"
                                                alt="avatar-female" />
                                        @else
                                            <img class="img-fluid"
                                                src="{{ asset('/assets/images/default/avatar-unknown.png') }}"
                                                alt="avatar-female" />
                                        @endif
                                    </div>
                                    <div class="team-content">
                                        <h3 class="name fs-6">{{ $booking['user_female']['fullname'] }}</h3>
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
                            </a>
                        </div>
                        <div class="d-none d-md-block col-md-2"></div>
                        <div class="col-6 col-md-5">
                            <a href="#">
                                <div class="our-team">
                                    <div class="picture"
                                        style="--after-bg:{{ $booking->hasUserAttended($booking['user_male_id']) ? '#00FF00' : '#FF0000' }};">
                                        @if ($booking['user_male']['gender'] == App\Enums\User\Gender::Female->value)
                                            <img class="img-fluid"
                                                src="{{ asset('/assets/images/default/avatar-girl.png') }}"
                                                alt="avatar-male" />
                                        @elseif($booking['user_male']['gender'] == App\Enums\User\Gender::Male->value)
                                            <img class="img-fluid"
                                                src="{{ asset('/assets/images/default/avatar-boy.png') }}"
                                                alt="avatar-male" />
                                        @else
                                            <img class="img-fluid"
                                                src="{{ asset('/assets/images/default/avatar-unknown.png') }}"
                                                alt="avatar-male" />
                                        @endif
                                    </div>
                                    <div class="team-content">
                                        <h3 class="name fs-6">{{ $booking['user_male']['fullname'] }}</h3>
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
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            @if ($booking['status'] == BookingStatus::Processing->value || $booking['status'] == BookingStatus::Confirmed->value)
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-default py-2 px-4" id="btn-completed">Hoàn thành cuộc
                        hẹn</button>
                </div>
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
        <div class="modal-backdrop" id="modalBackdrop">
            <div class="modal-custom">
                <div class="glow-ring"></div>
                <h2 id="modalTitle">A</h2>
                <p id="modalMessage">B</p>
                <button class="close-btn">Xác nhận</button>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    @include('partner.checkin.scripts.input-image')
    @include('partner.checkin.scripts.input-currency')
    <script>
        function detail($bookingCode) {
            const spans = document.querySelectorAll('span[onclick="userCheckin()"]');
            spans.forEach(span => {
                span.addEventListener('click', function() {
                    const userCode = this.getAttribute('data-user-code');
                    const bookingCode = this.getAttribute('data-booking-code');
                    if (!userCode || !bookingCode) {
                        alert('Không tìm thấy thông tin người dùng hoặc mã đặt chỗ.');
                        return;
                    }
                    const checkinUrl = `{{ url('/checkin/${bookingCode}/${userCode}') }}`;
                    window.location.href = checkinUrl;
                });
            });
        }
        document.addEventListener('DOMContentLoaded', userCheckin);
    </script>
    <script>
        const closeBtn = document.querySelector('.close-btn');
        const backdrop = document.getElementById('modalBackdrop');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');

        function completed(completedFormData) {
            fetch('{{ route('partner.checkin.completed') }}', {
                    method: 'POST',
                    body: completedFormData
                }).then(res => res.json())
                .then(data => {
                    if (data.status === 200) {
                        showModal('Thành công', data.message || 'Điểm danh thành công');
                        setTimeout(() => {
                            window.location.replace(
                                "{{ route('partner.checkin', ['code' => $booking['table']['code']]) }}"
                            );
                        }, 1000);
                    } else {
                        showModal('Thất bại', data.message ||
                            'Điểm danh thất bại, vui lòng thử lại');
                        setTimeout(hideModal, 5000);
                    }
                });
        }
        // ====== Modal helpers ======
        const showModal = (title, message) => {
            modalTitle.textContent = title || '';
            modalMessage.textContent = message || '';
            backdrop.style.display = 'flex';
        };
        const hideModal = () => (backdrop.style.display = 'none');
        closeBtn.addEventListener('click', hideModal);
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') hideModal();
        });
        $(document).ready(function() {
            $('#btn-completed').on("click", function(e) {
                e.preventDefault();
                let completedFormData = new FormData();
                completedFormData.append('_token', $('meta[name="X-TOKEN"]').attr('content'));
                completedFormData.append('id', $('input[name=id]').val());
                const totalVal = $('input[name=total]').val();
                if (totalVal && totalVal.trim() !== '') {
                    completedFormData.append('total', totalVal.trim());
                }
                const fileEl = $('input[name=invoice]')[0];
                if (fileEl && fileEl.files && fileEl.files[0]) {
                    completedFormData.append('invoice', fileEl.files[0]);
                }

                completed(completedFormData);
            });
        });
    </script>
@endpush
