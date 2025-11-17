@extends('partner.layouts.master')
@section('title', __('Đặt lại mật khẩu'))
@push('custom-css')
    @include('partner.auth.styles.style')
@endpush

@section('content')
    <div class="container mt-5">
        <div style="border: none; border-radius: 0" class="form-container">
            <h4 class="text-center fw-semibold fs-3">Cập nhật mật khẩu</h4>
            <x-form class="mt-3" type="post" :validate="true">
                <div class="row">
                    <div class="col-12">
                        <div class="position-relative mb-3">
                            <label class="form-label">Mật khẩu mới <span class="text-danger fw-semibold">*</span></label>
                            <div class="group-input">
                                <i class="s-icon ti ti-lock-filled"></i>
                                <x-input-password id="password" name="password" :required="true" placeholder="Mật khẩu mới" />
                                <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="position-relative mb-3">
                            <label class="form-label">Xác nhận mật khẩu <span
                                    class="text-danger fw-semibold">*</span></label>
                            <div class="group-input">
                                <i class="s-icon ti ti-lock-filled"></i>
                                <x-input-password id="passwordConfirm" name="password_confirmation" :required="true"
                                    data-parsley-equalto="input[name='password']"
                                    data-parsley-equalto-message="{{ __('Mật khẩu không khớp.') }}" placeholder="Xác nhận mật khẩu" />
                                <span toggle="#passwordConfirm" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3 text-center">
                            <button style="width: 100%;" type="submit" class="btn btn-default">Cập nhật</button>
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
