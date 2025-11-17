@extends('partner.layouts.master')
@section('title', __($title))

@push('libs-css')
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush

@push('custom-css')
    @include('partner.profile.styles.style')
@endpush

@section('content')
    <div class="container">
        <div>
            {{-- <div class="nav-tabs-container">
                <ul class="nav nav-tabs mt-4 py-1" id="myTab" role="tablist">
                    <li class="nav-item nav-item-first" role="presentation">
                        <button class="nav-link py-1 active" id="account-tab" data-bs-toggle="tab" data-bs-target="#account"
                            type="button" role="tab" aria-controls="account" aria-selected="true">Thông tin
                        </button>
                    </li>
                    <li class="nav-item nav-item-last" role="presentation">
                        <button class="nav-link py-1" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery"
                            type="button" role="tab" aria-controls="gallery" aria-selected="false">Hình ảnh
                        </button>
                    </li>
                </ul>
            </div> --}}

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                    <div id="tab-account">
                        @include('partner.profile.components.account-tabs.account-tab')
                    </div>
                </div>
                {{-- <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                    <div id="tab-gallery">
                        @include('partner.profile.components.account-tabs.gallery-tab')
                    </div>
                </div> --}}
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
    @include('partner.profile.scripts.gallery')
    @include('partner.profile.scripts.update-profile')
@endpush
