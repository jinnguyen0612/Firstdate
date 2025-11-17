@extends('admin.layouts.master')
<style>
    .stats-card {
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .stats-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

@php
    $percentUser = round((($profitUser + $profitPartner == 0)? 0:(($profitUser)/($profitUser + $profitPartner)) * 100),2);
    $percentPartner = round((($profitUser + $profitPartner == 0)? 0: (($profitPartner)/($profitUser + $profitPartner)) * 100),2);
@endphp

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center mb-1">
                <div class="col">
                    <h2 class="page-title">
                        {{ __('Dashboard') }}
                    </h2>
                </div>
            </div>
            <div class="row g-2 align-items-center">
                <div class="row g-3">

                    <!-- Lượt tải ứng dụng -->
                    <div class="col-sm-12 col-xl-4">
                        <div class="card h-90">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title fw-semibold">Lượt tải ứng dụng</h5>
                                </div>
                                <div class="d-flex flex-column gap-4">
                                    <!-- App Store -->
                                    <div class="d-flex align-items-center">
                                        <div class="rounded bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center"
                                            style="width: 36px; height: 36px;">
                                            <i class="ti ti-brand-appstore" style="font-size: 20px; color:white"></i>
                                            <!-- Icon here -->
                                            <!-- Your SVG -->
                                        </div>
                                        <div class="ms-3 w-100">
                                            <div class="d-flex justify-content-between fw-semibold text-muted mb-1">
                                                <h6 class="mb-0">App Store</h6>
                                                <span class="text-muted small">60%</span>
                                            </div>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar"
                                                    style="width: 65%; background: linear-gradient(to right, #009ffd, #2a2a72);">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- CH Play -->
                                    <div class="d-flex align-items-center">
                                        <div class="rounded bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center"
                                            style="width: 36px; height: 36px;">
                                            <i class="ti ti-brand-google-play" style="font-size: 20px; color:white"></i>
                                            <!-- SVG Icon -->
                                        </div>
                                        <div class="ms-3 w-100">
                                            <div class="d-flex justify-content-between fw-semibold text-muted mb-1">
                                                <h6 class="mb-0">CH Play</h6>
                                                <span class="text-muted small">40%</span>
                                            </div>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar"
                                                    style="width: 40%; background: linear-gradient(to right, #a71d31, #3f0d12);">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Luot tao profile -->
                    <div class="col-sm-6 col-xl-4">
                        <div class="card h-90">
                            <div class="card-body d-flex">
                                <div class="bg-primary bg-opacity-10 text-primary rounded d-flex justify-content-center align-items-center"
                                    style="width: 33px; height: 33px;">
                                    <!-- SVG Icon -->
                                    <i class="ti ti-users" style="font-size: 20px; color:white"></i>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-0 fw-semibold fs-5">{{ $totalProfiles }}</p>
                                    <small class="text-muted">Lượt tạo profile</small>
                                </div>
                            </div>
                            <div style="height: 130px; overflow: hidden;">
                                <div class="position-absolute bottom-0 w-100" x-ref="followers" id="followers-chart"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Doanh thu -->
                    <div class="col-sm-12 col-xl-4">
                        <div class="card h-90">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title fw-semibold">Doanh thu</h5>
                                </div>
                                <div class="d-flex flex-column gap-4">
                                    <!-- Nguoi dung -->
                                    <div class="d-flex align-items-center">
                                        <div class="rounded bg-opacity-10 text-primary d-flex align-items-center justify-content-center"
                                            style="width: 36px; height: 36px; background-color: #23eb23">
                                                <i class="ti ti-user-dollar" style="font-size: 20px; color:white"></i>
                                        </div>
                                        <div class="ms-3 w-100">
                                            <div class="d-flex justify-content-between fw-semibold text-muted mb-1">
                                                <h6 class="mb-0">Người dùng</h6>
                                                <span class="text-muted small">{{format_price($profitUser)}} ({{$percentUser}}%)</span>
                                            </div>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar"
                                                    style="width: {{$percentUser}}%; background: linear-gradient(to right, #23eb23, #137018);">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Doi tac -->
                                    <div class="d-flex align-items-center">
                                        <div class="rounded bg-opacity-10 text-danger d-flex align-items-center justify-content-center"
                                            style="width: 36px; height: 36px; background-color: #dad725">
                                            <!-- SVG Icon -->
                                            <i class="ti ti-cash" style="font-size: 20px; color:white"></i>
                                        </div>
                                        <div class="ms-3 w-100">
                                            <div class="d-flex justify-content-between fw-semibold text-muted mb-1">
                                                <h6 class="mb-0">Đối tác</h6>
                                                <span class="text-muted small">{{format_price($profitPartner)}} ({{$percentPartner}}%)</span>
                                            </div>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar"
                                                    style="width: {{$percentPartner}}%; background: linear-gradient(to right, #dad725, #5f5e00);">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-body">
        </div>
    @endsection

    @push('custom-js')
        @include('admin.dashboard.scripts.charts')
    @endpush
