@extends('partner.layouts.guest')

@section('title', $title)

@push('libs-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('custom-css')
    @include('partner.checkin.styles.style')
@endpush


@section('content')
    <div class="container">
        <div class="card shadow-sm p-3">
            <div class="title">
                <div class="app-name"><span class="logo"></span> <span style="margin-top: 10px">FirstDate</span></div>
                <div class="table-name">Bàn #{{ $code }}</div>
                <div class="booking-name">Nhập mật khẩu đăng nhập nhân viên
                </div>
            </div>
            <x-form :action="route('partner.checkin.staffLogin')" type="post" :validate="true">
                <div class="form-group pt-3 px-3 d-flex flex-column align-items-center">
                    <input type="hidden" name="code" value="{{ $code }}">
                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                    <button type="submit" class="mt-3 btn btn-default py-2 px-4" id="btn-login">Xác nhận</button>
                </div>
            </x-form>

            <div class="text-center mt-4">
                {{-- <button type="button" id="btn-checkin" class="btn btn-default py-2 px-4">Xác nhận</button> --}}
                <a href="#" class="app-icon">
                    <img width="40px" height="40px" src="{{ asset('public/assets/svg/google-play-svgrepo-com.svg') }}"
                        alt="CH Play">
                </a>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <a href="#" class="app-icon">
                    <img width="40px" height="40px" src="{{ asset('public/assets/svg/app-store-svgrepo-com.svg') }}"
                        alt="App Store">
                </a>
            </div>
        </div>
        <div class="modal-backdrop" id="modalBackdrop">
            <div class="modal-custom">
                <div class="glow-ring"></div>
                <h2 id="modalTitle">A</h2>
                <p id="modalMessage">B</p>
                <button class="close-btn">Xác nhận</button>
            </div>
        </div>
    </div>
@endsection
