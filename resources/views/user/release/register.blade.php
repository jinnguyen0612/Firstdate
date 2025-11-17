@extends('partner.layouts.guest')

@section('title', 'Đăng ký')


@push('custom-css')
    <style>
        .form-control:focus,
        .form-control:focus-visible {
            border: var(--bs-border-width) solid var(--bs-border-color);
        }
    </style>
    @include('user.release.styles.otp')
    @include('user.release.styles.login')
@endpush

@section('content')
    <main id="mainContent">
        <div class="btn-back" id="btn-back-container">
            <span id="btn-back" class="text-default p-3 fs-6"><i class="fa fa-chevron-left me-2" aria-hidden="true"></i>Quay
                lại</span>
        </div>
        <div id="sendOtp">
            <div class="container text-center d-flex justify-content-center align-items-center flex-column"
                style="height: 60vh;">
                <div class="text-center image-container mb-3 p-3">
                    <img class="img-fluid" src="{{ asset('user/assets/release/svg/Logo-circle.svg') }}" alt="">
                </div>
                <h2 class="sendOtp-title">Bắt đầu với Firstdate</h2>
                <div class="phone-input">
                    <input class="form-control shadow-sm mb-2" name="email" placeholder="Nhập email" type="email">
                    <input class="form-control shadow-sm" name="phone" placeholder="Nhập số điện thoại"
                        type="text">
                </div>
                <div class="btn-group">
                    <button class="btn btn-default" id="submitOtp">Tiếp tục</button>
                </div>
            </div>
        </div>
        <div id="verify" class="d-none">
            <div class="container text-center d-flex justify-content-center align-items-center flex-column">
                <div class="text-center image-container mb-3 p-3">
                    <img class="img-fluid" src="{{ asset('user/assets/release/svg/icon-verify-otp.svg') }}" alt="">
                </div>
                <h2>Nhập mã pin cho tài khoản</h2>
                <p>Mã pin được dùng để đăng nhập tài khoản khi đăng nhập bằng số điện thoại</p>

                <div class="text-center d-flex flex-column justify-content-center align-items-center">
                    <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                        <input class="m-1 text-center form-control rounded" type="text" inputmode="numeric"
                            pattern="[0-9]*" id="first" maxlength="1" />
                        <input class="m-1 text-center form-control rounded" type="text" inputmode="numeric"
                            pattern="[0-9]*" id="second" maxlength="1" />
                        <input class="m-1 text-center form-control rounded" type="text" inputmode="numeric"
                            pattern="[0-9]*" id="third" maxlength="1" />
                        <input class="m-1 text-center form-control rounded" type="text" inputmode="numeric"
                            pattern="[0-9]*" id="fourth" maxlength="1" />
                        <input class="m-1 text-center form-control rounded" type="text" inputmode="numeric"
                            pattern="[0-9]*" id="fourth" maxlength="1" />
                        <input class="m-1 text-center form-control rounded" type="text" inputmode="numeric"
                            pattern="[0-9]*" id="fourth" maxlength="1" />
                        <input type="hidden" name="pin">
                    </div>
                    <div class="btn-group mt-3">
                        <button class="btn btn-default" id="validateBtn">Xác nhận</button>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </main>
@endsection

@push('libs-js')
    <script defer src="https://cdn.jsdelivr.net/npm/framework7@latest/framework7-bundle.min.js"></script>
@endpush

@push('custom-js')
    @include('user.release.scripts.otp')
    @include('user.release.scripts.otpInputRegister')
    @include('user.release.scripts.countdown')
@endpush
