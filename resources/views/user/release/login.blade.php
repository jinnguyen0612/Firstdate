@extends('partner.layouts.guest')

@section('title', 'Đăng nhập')

@push('libs-css')
@endpush
@push('custom-css')
    @include('user.release.styles.otp')
    @include('user.release.styles.login')
@endpush

@section('content')
    <main id="mainContent">
        <div class="btn-back">
            <span id="btn-back" class="text-default p-3 fs-6">
                <i class="fa fa-chevron-left me-2" aria-hidden="true"></i>Quay lại
            </span>
        </div>

        {{-- Bước 1: nhập username --}}
        <div id="sendOtp">
            <div class="container text-center d-flex justify-content-center align-items-center flex-column"
                style="height: 60vh;">
                <div class="text-center image-container mb-3 p-3">
                    <img class="img-fluid" src="{{ asset('user/assets/release/svg/Logo-circle.svg') }}" alt="">
                </div>
                <h2 class="sendOtp-title">Đăng nhập vào Firstdate</h2>
                <div class="phone-input">
                    <input class="form-control shadow-sm" name="username" placeholder="Nhập email/số điện thoại"
                        type="text">
                </div>
                <div class="btn-group">
                    <button class="btn btn-default" id="submitOtp">Tiếp tục</button>
                </div>
            </div>
        </div>

        {{-- Bước 2: verify (OTP / PIN) --}}
        <div id="verify" class="d-none">
            <div class="container text-center d-flex justify-content-center align-items-center flex-column"
                style="height: 60vh;">
                <div class="text-center image-container mb-3 p-3">
                    <img class="img-fluid" src="{{ asset('user/assets/release/svg/icon-verify-otp.svg') }}" alt="">
                </div>
                <h2 class="">Nhập mã xác thực</h2>
                <p>
                    Một mã xác thực đã được gửi đến email
                    <span id="phone"></span>, vui lòng kiểm tra tin nhắn của bạn
                </p>

                <div class="text-center d-flex flex-column justify-content-center align-items-center">
                    <div id="otp" class="inputs d-flex justify-content-center mt-2">
                        {{-- 4 ô đầu cho OTP, 2 ô sau dành cho PIN (ẩn mặc định) --}}
                        <input class="m-1 text-center form-control rounded" type="text" inputmode="numeric"
                            pattern="[0-9]*" id="first" maxlength="1" />
                        <input class="m-1 text-center form-control rounded" type="text" inputmode="numeric"
                            pattern="[0-9]*" id="second" maxlength="1" />
                        <input class="m-1 text-center form-control rounded" type="text" inputmode="numeric"
                            pattern="[0-9]*" id="third" maxlength="1" />
                        <input class="m-1 text-center form-control rounded" type="text" inputmode="numeric"
                            pattern="[0-9]*" id="fourth" maxlength="1" />
                        <input class="m-1 text-center form-control rounded pin-extra d-none" type="text"
                            inputmode="numeric" pattern="[0-9]*" id="fifth" maxlength="1" />
                        <input class="m-1 text-center form-control rounded pin-extra d-none" type="text"
                            inputmode="numeric" pattern="[0-9]*" id="sixth" maxlength="1" />

                        <input type="hidden" name="pin">
                    </div>

                    <div class="text-center my-3 d-none" id="otp-error">
                        <span class="text-default fs-6 fs-sm-text">
                            Mã OTP / PIN không đúng. Vui lòng kiểm tra lại
                        </span>
                    </div>

                    <div class="text-center my-3" id="timer-container">
                        <span class="text-default fs-6 fs-sm-text">
                            Bạn có thể yêu cầu gửi lại mã sau:
                            <span id="timer"></span>
                        </span>
                    </div>

                    <div class="btn-group d-none" id="resend-otp-container">
                        <button class="btn btn-default" type="button" id="resend-otp">Gửi lại mã mới</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('custom-js')
    @include('user.release.scripts.login')
    @include('user.release.scripts.otpInput')
    @include('user.release.scripts.countdown')
@endpush
