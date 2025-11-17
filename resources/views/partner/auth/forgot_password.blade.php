@extends('partner.layouts.master')
@section('title', __('Quên mật khẩu'))

@push('custom-css')
	@include('partner.auth.styles.style')
@endpush

@section('content')
    <div class="container mt-5">
        <div style="border: none; border-radius: 0" class="form-container">
            <h4 class="text-center fw-semibold fs-3">Quên mật khẩu</h4>
            <x-form class="mt-3" type="post" :validate="true">
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
                        <div class="mb-3 text-end">
                            <a href="{{ route('partner.login') }}" style="width: 100%;" type="Quên mật khẩu" class="">Đăng nhập</a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3 text-center">
                            <button style="width: 100%;" type="submit" class="btn btn-default">Tìm tài khoản</button>
                        </div>
                    </div>
                </div>
            </x-form>

        </div>
    </div>
@endsection
<!-- Thêm một đoạn JavaScript để điều khiển sự hiển thị mật khẩu -->
@push('custom-js')
@endpush



