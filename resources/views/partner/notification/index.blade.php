@extends('partner.layouts.master')
@section('title', __($title))

@push('custom-css')
    @include('partner.notification.styles.style')
    @include('partner.notification.styles.button-send')
@endpush

@section('content')
    <div class="container">
        {{-- Laptop --}}
        <div class="mail-box mt-5 laptop-view">
            <aside class="lg-side">
                <div class="inbox-head d-flex align-items-center">
                    <h3 class="mb-3 form-title">Thông báo</h3>
                </div>
                <div class="inbox-body">
                    <div id="tab-inbox-content" class="tab-pane active-tab">
                        @include('partner.notification.components.table-notification', [
                            'notifications' => $notifications,
                        ])
                    </div>
                </div>
            </aside>
        </div>
        {{-- Mobile --}}

        <div class="mobile-view">
            <div class="row">
                <div class="col-12 px-2 pt-0 pb-4 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <button id="btn-read-all" class="btn text-default" style="font-size: 1.2rem"><i
                                class="ti ti-checks"></i> Đọc tất cả</button>
                        <button id="btn-delete-read" class="btn text-default" style="font-size: 1.4rem"
                            data-bs-toggle="modal" data-bs-target="#confirmModal"><i
                                class="ti ti-trash-filled"></i></button>
                    </div>
                    <div id="notificationListContainer" class="mobile-notification-container">

                        @include('partner.notification.components.mobile-notification', [
                            'notifications' => $notifications,
                        ])
                    </div>
                    <div id="loading-spinner" style="display:none; text-align:center; padding:10px;">
                        <i class="ti ti-loader ti-spin"></i> Đang tải thêm...
                    </div>

                    <div id="end-message" style="display:none; text-align:center; padding:10px; color:gray;">
                        Đã tải hết thông báo.
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Xóa tất cả thông báo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Bạn có chắc chắn xóa tất cả thông báo không?
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn text-default w-40" data-bs-dismiss="modal">Hủy</button>
                            <button id="btn-accept-delete" type="button" class="btn btn-default w-40">Đồng ý</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('libs-js')
    <script src="./libs/gsap/gsap.min.js"></script>
@endpush

@push('custom-js')
    @include('partner.notification.scripts.scripts')
    @include('partner.notification.scripts.button-send')
    @include('partner.notification.scripts.table-notification')
    @include('partner.notification.scripts.mobile-notification')
@endpush
