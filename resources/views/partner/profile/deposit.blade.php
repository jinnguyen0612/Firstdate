@extends('partner.layouts.master')
@section('title', __($title))

@push('libs-css')
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush

@push('custom-css')
    @include('partner.profile.styles.style')
    @include('partner.profile.styles.deposit')
@endpush

@php
    $content =
        'NAP' .
        $amount .
        '_' .
        $settings->where('setting_key', 'account_number')->pluck('plain_value')->first();
    $accountNumber = $settings->where('setting_key', 'account_number')->pluck('plain_value')->first();
    $accountName = $settings->where('setting_key', 'account_name')->pluck('plain_value')->first();
    $bankName = $settings->where('setting_key', 'bank_name')->pluck('plain_value')->first();
@endphp

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3 d-flex align-items-center justify-content-center">
                <div class="image-container">
                    <img src="{{ asset($settings->where('setting_key', 'qr_code')->pluck('plain_value')->first()) }}"
                        alt="">
                </div>
            </div>
            <div class="col-12 col-md-1 divider-container">
                <div class="divider"></div>
                <span class="p-2">Hoặc</span>
                <div class="divider"></div>
            </div>
            <div class="col-12 col-md-4 d-flex flex-column align-items-center justify-content-around">
                <div class="w-100 shadow-sm p-3 rounded mb-2">
                    <label for="" class="form-label fw-semibold fs-6">Tên ngân hàng</label>
                    <div class="d-flex align-items-between text-black">
                        <span class="d-flex align-items-center fs-5">
                            <i class="ti ti-credit-card-filled me-2" style="font-size: 1.5rem; color: #808080"></i>
                            <span>
                                {{ $bankName }}
                            </span>
                        </span>
                        <span class="ms-auto d-flex align-items-center">
                            <button type="button" class="btn" onclick="copyToClipboard('{{ $bankName }}')">
                                <i class="ti ti-copy" style="font-size: 1.5rem;"></i>
                            </button>
                        </span>
                    </div>
                </div>

                <div class="w-100 shadow-sm p-3 rounded mb-2">
                    <label for="" class="form-label fw-semibold fs-6">Chủ tài khoản</label>
                    <div class="d-flex align-items-between text-black">
                        <span class="d-flex align-items-center fs-5">
                            <i class="ti ti-user-filled me-2" style="font-size: 1.5rem; color: #808080"></i>
                            <span>
                                {{ $accountName }}
                            </span>
                        </span>
                        <span class="ms-auto d-flex align-items-center">
                            <button type="button" class="btn" onclick="copyToClipboard('{{ $accountName }}')">
                                <i class="ti ti-copy" style="font-size: 1.5rem;"></i>
                            </button>
                        </span>
                    </div>
                </div>

                <div class="w-100 shadow-sm p-3 rounded mb-2">
                    <label for="" class="form-label fw-semibold fs-6">Số tài khoản</label>
                    <div class="d-flex align-items-between text-black">
                        <span class="d-flex align-items-center fs-5">
                            <i class="ti ti-credit-card-filled me-2" style="font-size: 1.5rem; color: #808080"></i>
                            <span>
                                {{ $accountNumber }}
                            </span>
                        </span>
                        <span class="ms-auto d-flex align-items-center">
                            <button type="button" class="btn" onclick="copyToClipboard('{{ $accountNumber }}')">
                                <i class="ti ti-copy" style="font-size: 1.5rem;"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-1 divider-container title-mobile-deposit">
                <div class="divider"></div>
                <span class="p-2 fw-semibold fs-5">Nội dung chuyển khoản</span>
                <div class="divider"></div>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <div class="d-flex flex-column align-items-center justify-content-around">
                    <div class="title-deposit">
                        <label for="" class="form-label fw-semibold fs-5">Nội dung chuyển khoản</label>
                    </div>

                    <div class="w-100 shadow-sm p-3 rounded mb-2">
                        <label for="" class="form-label fw-semibold fs-6">Số tiền</label>
                        <div class="d-flex align-items-between text-black">
                            <span class="d-flex align-items-center fs-5">
                                <i class="ti ti-cash-banknote me-2" style="font-size: 1.5rem; color: #808080"></i>
                                <span>
                                    {{ format_price(((float)$amount)) }}
                                </span>
                                <input type="hidden" name="amount" value="{{ ((float)$amount) }}">
                            </span>
                            <span class="ms-auto d-flex align-items-center">
                                <button type="button" class="btn" onclick="copyToClipboard('{{ (float)$amount }}')">
                                    <i class="ti ti-copy" style="font-size: 1.5rem;"></i>
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="w-100 shadow-sm p-3 rounded">
                        <label for="" class="form-label fw-semibold fs-6">Nội dung</label>
                        <div class="d-flex align-items-between text-black">
                            <span class="d-flex align-items-center fs-5">
                                <i class="ti ti-cash-banknote me-2" style="font-size: 1.5rem; color: #808080"></i>
                                <span class="content-wrap">
                                    {{ $content }}
                                </span>
                                <input type="hidden" name="description" value="{{ $content }}">
                            </span>
                            <span class="ms-auto d-flex align-items-center">
                                <button type="button" class="btn" onclick="copyToClipboard('{{ $content }}')">
                                    <i class="ti ti-copy" style="font-size: 1.5rem;"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-2 text-center my-3">
                <div class="image-input d-flex flex-column align-items-center">
                    <input type="file" accept="image/*" id="imageInput">
                    <label for="imageInput" class="image-button"><i class="far fa-image"></i> Chọn hình ảnh hóa đơn</label>
                    <img src="" class="image-preview" onclick="showFullImage(this)">
                    <span class="change-image">Chọn hình ảnh khác</span>
                </div>
            </div>

            <div class="col-12 mt-2 mb-3 text-center">
                <button type="button" class="btn btn-default btnComplete">
                    Hoàn tất
                </button>
            </div>
        </div>
    </div>
@endsection

@push('libs-js')
    <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/i18n/' . trans()->getLocale() . '.js') }}"></script>
@endpush

@push('custom-js')
    @include('partner.profile.scripts.scripts')
    @include('partner.profile.scripts.image')
    @include('partner.profile.scripts.select2')
    @include('partner.profile.scripts.deposit-image')
    @include('partner.profile.scripts.send-deposit')
@endpush
