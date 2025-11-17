@extends('partner.layouts.master')
@section('title', __($title))

@push('custom-css')
    @include('partner.setting.styles.styles')
@endpush

@section('content')
    <div class="container mt-3 mt-md-0">
        <div class="cs-blog-detail">
            <div class="cs-main-post">
                <figure><img onload="pagespeed.CriticalImages.checkImageForCriticality(this);"
                        data-pagespeed-url-hash="2714250504" alt="jobline-blog (8)"
                        src="{{ asset('assets/images/firstdate-icon-default.png')}}">
                </figure>
            </div>
            <div class="post-title mt-3">
                <h4 class="cs-post-title fs-4">Điều khoản và chính sách</h4>
            </div>
            <div class="cs-post-option-panel">
                <div class="rich-editor-text">
                    {!! $policy !!}
                </div>
            </div>
        </div>
    </div>

@endsection
