@extends('admin.layouts.master')
@push('libs-css')
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush
@push('custom-css')
    @include('admin.package.styles.styles')
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form :action="route('admin.package.update')" type="put" :validate="true">
                <x-input type="hidden" name="id" :value="$package->id" />
                <div class="row justify-content-center">
                    @include('admin.package.forms.edit-left')
                    @include('admin.package.forms.edit-right')
                </div>
            </x-form>
        </div>
    </div>
@endsection

@push('libs-js')
    <!-- ckfinder js -->
    @include('ckfinder::setup')
    <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/i18n/vi.js') }}"></script>
    <script src="{{ asset('/public/libs/jquery-throttle-debounce/jquery.ba-throttle-debounce.min.js') }}"></script>
@endpush

@push('custom-js')
    <script>
        $('.select2-bs5').select2({
            language: "vi",
            theme: 'bootstrap-5'
        });
    </script>
    @include('admin.package.scripts.scripts')
@endpush
