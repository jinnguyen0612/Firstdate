@extends('partner.layouts.master')
@section('title', __('Xác nhận OTP'))

@push('custom-css')
    @include('partner.auth.styles.style')
@endpush

@section('content')
    <div class="container mt-5">
        <div style="border: none; border-radius: 0">
            <h4 class="text-center fw-semibold fs-4 fs-sm-title">Chúng tôi đã gửi mã OTP qua email</h4>
            <div class="d-flex fs-4 justify-content-center align-items-center">
                <i class="ti ti-mail-filled me-2" style="font-size: 1.7rem"></i>
                <span>n19**********u.vn</span>
            </div>
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-md-8 col-lg-7 p-4">
                    <div class="">
                        <h4 class="text-center">OTP Verificattion</h4>
                        <div class="text-center">
                            <form action="" class="otp-form">
                                <span class="otp-container">
                                    <input class="otp-field" type="text" name="opt-field[]" maxlength=1>
                                </span>
                                <span class="otp-container">
                                    <input class="otp-field" type="text" name="opt-field[]" maxlength=1>
                                </span>
                                <span class="otp-container">
                                    <input class="otp-field" type="text" name="opt-field[]" maxlength=1>
                                </span>
                                <span class="otp-container">
                                    <input class="otp-field" type="text" name="opt-field[]" maxlength=1>
                                </span>
                                <span class="otp-container">
                                    <input class="otp-field" type="text" name="opt-field[]" maxlength=1>
                                </span>
                                <span class="otp-container">
                                    <input class="otp-field" type="text" name="opt-field[]" maxlength=1>
                                </span>
                                <!-- Store OTP Value -->
                                <input class="otp-value" type="hidden" name="opt-value">
                                <div class="text-center my-3"><span class="text-default fs-6 fs-sm-text">Mã OTP không đúng. Vui lòng
                                        kiểm tra lại</span></div>
                                <div class="text-center my-3">
                                    <span class="text-default fs-6 fs-sm-text">Gửi lại mã: <span id="timer"></span> <a class="d-none" id="resend-otp" href="#">Gửi lại</a></span>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3 text-center">
                                        <button style="width: 100%;" type="submit" class="btn btn-default">Xác nhận</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
<!-- Thêm một đoạn JavaScript để điều khiển sự hiển thị mật khẩu -->
@push('custom-js')
    @include('partner.auth.scripts.otpInput')
    @include('partner.auth.scripts.countdown')
@endpush
