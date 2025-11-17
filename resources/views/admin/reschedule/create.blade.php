@extends('admin.layouts.master')

@push('libs-css')
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush

@push('custom-css')
@endpush


@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form :action="route('admin.reschedule.store')" type="post" :validate="true">
                <div class="row justify-content-center">
                    @include('admin.reschedule.forms.create-left')
                    @include('admin.reschedule.forms.create-right')
                </div>
            </x-form>
        </div>
    </div>
@endsection
{{-- @push('libs-js')
    <script src="{{ asset('public/libs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/libs/ckeditor/adapters/jquery.js') }}"></script>
    @include('ckfinder::setup')
    <!-- button in datatable -->
    <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/i18n/' . trans()->getLocale() . '.js') }}"></script>
@endpush --}}
@push('libs-js')
    <script src="{{ asset('public/libs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/libs/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/i18n/' . trans()->getLocale() . '.js') }}"></script>
    <script src="{{ asset('/public/libs/jquery-throttle-debounce/jquery.ba-throttle-debounce.min.js') }}"></script>
    <script src='{{ asset('/public/libs/full-calendar/index.global.min.js') }}'></script>
@endpush
@push('custom-js')
    @include('admin.layouts.modal.modal-pick-address')
    @include('admin.scripts.google-map-input')
    @include('admin.reschedule.scripts.scripts')
@endpush
