@extends('partner.layouts.master')
@section('title', __($title))

@push('custom-css')
    @include('partner.profile.styles.style')
@endpush

@section('content')
    <div class="container">
        <div class="mobile-view">
            <div id="mobile-history-container">
                @include('partner.profile.components.mobile-history')
            </div>
            <div id="loading-spinner" style="display:none; text-align:center; padding:10px;">
                <i class="ti ti-loader ti-spin"></i> Đang tải thêm...
            </div>

            <div id="end-message" style="display:none; text-align:center; padding:10px; color:gray;">
                Đã tải hết lịch sử giao dịch
            </div>
        </div>
        <div class="laptop-view">
            <aside class="lg-side">
                <div class="inbox-head d-flex align-items-center">
                    <h3 class="mb-3 form-title">Lịch sử giao dịch</h3>
                </div>
                <div class="inbox-body">
                    <div id="tab-inbox-content" class="tab-pane active-tab">
                        @include('partner.profile.components.laptop-history')
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection

@push('custom-js')
    @include('partner.profile.scripts.scripts')
    @include('partner.profile.scripts.history')
@endpush
