@extends('partner.layouts.master')
@section('title', __('Đăng nhập'))
@push('custom-css')
	@include('partner.auth.styles.style')
@endpush

@section('content')
    <div class="container mt-5">
        <div style="border: none; border-radius: 0" class="form-container">
            <h4 class="text-center fw-semibold fs-3">Đăng nhập</h4>
            <x-form :action="route('partner.login.submit')" class="mt-3" type="post" :validate="true">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger fw-semibold">*</span></label>
                            <div class="group-input">
								<i class="s-icon ti ti-mail-filled"></i>
                                <x-input-email name="email" :required="true" />
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="position-relative mb-3">
                            <label class="form-label">Mật khẩu <span class="text-danger fw-semibold">*</span></label>
                            <div class="group-input">
								<i class="s-icon ti ti-lock-filled"></i>
                                <x-input-password id="password" name="password" :required="true" />
                                <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3 text-end">
                            <a href="{{ route('partner.forgotPasswordView') }}" style="width: 100%;" type="Quên mật khẩu" class="">Quên mật khẩu?</a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3 text-center">
                            <button style="width: 100%;" type="submit" class="btn btn-default">Đăng nhập</button>
                        </div>
                    </div>
                </div>
            </x-form>

        </div>
    </div>
@endsection
<!-- Thêm một đoạn JavaScript để điều khiển sự hiển thị mật khẩu -->
@push('custom-js')
    <script>
        $(document).ready(function() {
            $(".toggle-password").click(function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                const input = $(this).attr("toggle");
                if ($(input).attr("type") === "password") {
                    $(input).attr("type", "text");
                } else {
                    $(input).attr("type", "password");
                }
            });
        });
    </script>
@endpush



