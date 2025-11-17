@extends('partner.layouts.master')
@section('title', __($title))

@push('custom-css')
    @include('partner.notification.styles.style')
    @include('partner.notification.styles.button-send')
@endpush

@section('content')
    <div class="container mt-3 mt-md-0">
        <div class="cs-blog-detail">
            <div class="cs-main-post">
                <figure><img onload="pagespeed.CriticalImages.checkImageForCriticality(this);"
                        data-pagespeed-url-hash="2714250504" alt="jobline-blog (8)"
                        src="{{ $notification->image ? asset($notification->image) : asset('assets/images/bg-mail-authen.jpg') }}">
                </figure>
            </div>
            <div class="post-title mt-3">
                <h4 class="cs-post-title fs-4">{{ $notification->title }}</h4>
                <span class="post-date cs-color py-4"><span><i class="ti ti-clock me-1" style="font-size: 1.1rem"></i><span class="time-diff"
                            data-time="{{ $notification->created_at->toIso8601String() }}"></span></span></span>
            </div>
            <div class="cs-post-option-panel">
                <div class="rich-editor-text">
                    {!! $notification->message !!}
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
@endpush
