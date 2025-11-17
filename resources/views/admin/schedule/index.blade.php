@extends('admin.layouts.master')

@push('libs-css')
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush

@push('custom-css')
    @include('admin.schedule.styles.styles')
    @include('admin.schedule.styles.schedule')
@endpush

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12 mt-3">
                <div class="card px-2 py-3">
                    <div class="card-header">
                        <h2 class="mb-0">{{ __('Lịch học tuần này:') }}</h2>
                    </div>
                    <div class="card-body"> 
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('libs-js')
    <script src="{{ asset('public/libs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/libs/ckeditor/adapters/jquery.js') }}"></script>
    @include('ckfinder::setup')
    <!-- button in datatable -->
    <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/i18n/' . trans()->getLocale() . '.js') }}"></script>
@endpush
@push('custom-js')
    @include('admin.layouts.modal.modal-pick-address')
    @include('admin.scripts.google-map-input')
    @include('admin.schedule.scripts.scripts')
    <script src='{{ asset('/public/libs/full-calendar/index.global.min.js') }}'></script>
    @include('admin.schedule.scripts.schedule')
@endpush
