@extends('partner.layouts.master')
@section('title', __($title))

@push('custom-css')
    @include('partner.profile.styles.style')
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 d-flex flex-column align-items-center justify-content-start partner-info">
                <div class="avatar-wrapper">
                    <img class="avatar" src="{{ asset($currentPartner->avatar??'assets/images/anhthumb.jpg') }}" alt="avatar">
                </div>
                <div class="infor mt-3">
                    <div class="partner-name text-wrap">
                        {{ $currentPartner->name }}
                    </div>
                    {{-- <div class="partner-type">{{ $currentPartner['partner_category']['name'] }}</div> --}}
                </div>
            </div>
            <div class="col-12 col-md-8 group-tab">
                {{-- <div class="card card-wallet w-100">
                    <div class="top-section">
                        <div class="icons">
                            <div class="logo">
                                <svg width="25" height="20" viewBox="0 0 20 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16 0H4C1.79 0 0 1.79 0 4V12C0 14.21 1.79 16 4 16H16C18.21 16 20 14.21 20 12V4C20 1.79 18.21 0 16 0ZM14.14 9.77C13.9 9.97 13.57 10.05 13.26 9.97L2.15 7.25C2.45 6.52 3.16 6 4 6H16C16.67 6 17.26 6.34 17.63 6.84L14.14 9.77ZM4 2H16C17.1 2 18 2.9 18 4V4.55C17.41 4.21 16.73 4 16 4H4C3.27 4 2.59 4.21 2 4.55V4C2 2.9 2.9 2 4 2Z"
                                        fill="#FFE1E1" />
                                </svg>
                                <span class="logo-text">Ví DatePoint</span>
                            </div>
                        </div>
                        <div class="wallet ms-3 mt-2 d-flex align-items-center">
                            <span class="me-2">
                                {{ format_price($currentPartner['wallet']) }}
                            </span>
                        </div>
                    </div>

                    <div class="bottom-section">
                        <div class="row">
                            <div class="item">
                                <a href="{{ route('partner.profile.transactions') }}" class="text-white">
                                    <span class="big-text"><i class="ti ti-history" style="font-size: 1.6rem"></i></span>
                                    <span class="big-text">Lịch sử</span>
                                </a>
                            </div>
                            <div class="item">
                                <button id="btnWithdraw" class="btn p-0 text-white" style="font-size: 1.4rem"
                                    data-bs-toggle="modal" data-bs-target="#modelWallet">
                                    <span class="big-text">
                                        <svg width="30" height="28" viewBox="0 0 25 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18.5 4H6.5C4.29 4 2.5 5.79 2.5 8V16C2.5 18.21 4.29 20 6.5 20H18.5C20.71 20 22.5 18.21 22.5 16V8C22.5 5.79 20.71 4 18.5 4ZM16.64 13.77C16.4 13.97 16.07 14.05 15.76 13.97L4.65 11.25C4.95 10.52 5.66 10 6.5 10H18.5C19.17 10 19.76 10.34 20.13 10.84L16.64 13.77ZM6.5 6H18.5C19.6 6 20.5 6.9 20.5 8V8.55C19.91 8.21 19.23 8 18.5 8H6.5C5.77 8 5.09 8.21 4.5 8.55V8C4.5 6.9 5.4 6 6.5 6Z"
                                                fill="white" />
                                            <path
                                                d="M12 6C12 2.68629 14.6863 0 18 0C21.3137 0 24 2.68629 24 6C24 9.31371 21.3137 12 18 12C14.6863 12 12 9.31371 12 6Z"
                                                fill="white" />
                                            <path
                                                d="M18 0.0498047C21.2861 0.0498047 23.9502 2.71391 23.9502 6C23.9502 9.28609 21.2861 11.9502 18 11.9502C14.7139 11.9502 12.0498 9.28609 12.0498 6C12.0498 2.71391 14.7139 0.0498047 18 0.0498047Z"
                                                stroke="black" stroke-opacity="0.3" stroke-width="0.1" />
                                            <path
                                                d="M20.0013 6.33317H16.0013C15.818 6.33317 15.668 6.18317 15.668 5.99984C15.668 5.8165 15.818 5.6665 16.0013 5.6665H20.0013C20.1846 5.6665 20.3346 5.8165 20.3346 5.99984C20.3346 6.18317 20.1846 6.33317 20.0013 6.33317Z"
                                                fill="#FFCC00" />
                                        </svg>
                                    </span>
                                    <span class="big-text">Rút tiền</span>
                                </button>
                            </div>
                            <div class="item">
                                <button id="btnDeposit" class="btn p-0 text-white" style="font-size: 1.4rem"
                                    data-bs-toggle="modal" data-bs-target="#modelWallet">
                                    <span class="big-text">
                                        <svg width="30" height="28" viewBox="0 0 25 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18.1641 4H6.16406C3.95406 4 2.16406 5.79 2.16406 8V16C2.16406 18.21 3.95406 20 6.16406 20H18.1641C20.3741 20 22.1641 18.21 22.1641 16V8C22.1641 5.79 20.3741 4 18.1641 4ZM16.3041 13.77C16.0641 13.97 15.7341 14.05 15.4241 13.97L4.31406 11.25C4.61406 10.52 5.32406 10 6.16406 10H18.1641C18.8341 10 19.4241 10.34 19.7941 10.84L16.3041 13.77ZM6.16406 6H18.1641C19.2641 6 20.1641 6.9 20.1641 8V8.55C19.5741 8.21 18.8941 8 18.1641 8H6.16406C5.43406 8 4.75406 8.21 4.16406 8.55V8C4.16406 6.9 5.06406 6 6.16406 6Z"
                                                fill="white" />
                                            <path
                                                d="M11.6641 6C11.6641 2.68629 14.3504 0 17.6641 0C20.9778 0 23.6641 2.68629 23.6641 6C23.6641 9.31371 20.9778 12 17.6641 12C14.3504 12 11.6641 9.31371 11.6641 6Z"
                                                fill="white" />
                                            <path
                                                d="M17.6641 0.0498047C20.9502 0.0498047 23.6143 2.71391 23.6143 6C23.6143 9.28609 20.9502 11.9502 17.6641 11.9502C14.378 11.9502 11.7139 9.28609 11.7139 6C11.7139 2.71391 14.378 0.0498047 17.6641 0.0498047Z"
                                                stroke="black" stroke-opacity="0.3" stroke-width="0.1" />
                                            <path
                                                d="M19.6654 6.33317H17.9987V7.99984C17.9987 8.18317 17.8487 8.33317 17.6654 8.33317C17.482 8.33317 17.332 8.18317 17.332 7.99984V6.33317H15.6654C15.482 6.33317 15.332 6.18317 15.332 5.99984C15.332 5.8165 15.482 5.6665 15.6654 5.6665H17.332V3.99984C17.332 3.8165 17.482 3.6665 17.6654 3.6665C17.8487 3.6665 17.9987 3.8165 17.9987 3.99984V5.6665H19.6654C19.8487 5.6665 19.9987 5.8165 19.9987 5.99984C19.9987 6.18317 19.8487 6.33317 19.6654 6.33317Z"
                                                fill="#34C759" />
                                        </svg>
                                    </span>
                                    <span class="big-text">Nạp tiền</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="tabs-content mt-4">
                    <div class="mb-2">
                        <a href="{{ route('partner.profile.account') }}">
                            <div class="d-flex align-items-between text-black shadow-sm px-2 py-3">
                                <span class="d-flex align-items-center fs-5">
                                    <i class="ti ti-building-store me-2" style="font-size: 1.5rem; color: #808080"></i>
                                    <span>
                                        Thông tin nhân viên đặt bàn
                                    </span>
                                </span>
                                <span class="ms-auto d-flex align-items-center">
                                    <i class="ti ti-chevron-right" style="font-size: 1.5rem;"></i>
                                </span>
                            </div>
                        </a>
                    </div>

                    <div class="mb-2">
                        <a href="{{ route('partner.setting.policy') }}">
                            <div class="d-flex align-items-between text-black shadow-sm px-2 py-3">
                                <span class="d-flex align-items-center fs-5">
                                    <i class="ti ti-shield-lock-filled me-2"
                                        style="font-size: 1.5rem; color: #808080"></i>
                                    <span>
                                        Chính sách và điều khoản
                                    </span>
                                </span>
                                <span class="ms-auto d-flex align-items-center">
                                    <i class="ti ti-chevron-right" style="font-size: 1.5rem;"></i>
                                </span>
                            </div>
                        </a>
                    </div>

                    <div class="mb-2">
                        <a href="#">
                            <div class="d-flex align-items-between text-black shadow-sm px-2 py-3">
                                <span class="d-flex align-items-center fs-5">
                                    <i class="ti ti-phone-filled me-2" style="font-size: 1.5rem; color: #808080"></i>
                                    <span>
                                        Liên hệ
                                    </span>
                                </span>
                                <span class="ms-auto d-flex align-items-center">
                                    <i class="ti ti-chevron-right" style="font-size: 1.5rem;"></i>
                                </span>
                            </div>
                        </a>
                    </div>

                    <div class="mt-4 mb-5">
                        <a href="{{ route('partner.logout') }}">
                            <div class="btn text-center text-default w-100 py-2 fs-3 btn-logout">
                                Đăng xuất
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modelWallet" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="group-wallet mb-3">
                            <input id="inputWallet" type="text" readonly required class="input-wallet form-control" placeholder="0">
                            <span class="icon-wallet fw-bold">
                                đ
                            </span>
                            <input type="hidden" name="amount">
                        </div>
                        <div class="list-price">
                            @foreach ($priceList as $price)
                                <span class="badge-button cursor-pointer"
                                    data-heart-value="{{ $price->price . '|' . ($price->value*1000) }}">
                                    {{ number_format($price->value * 1000) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button id="submit" type="button" class="btn btn-default w-100 modal-submit"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    @include('partner.profile.scripts.scripts')
@endpush
