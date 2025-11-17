@extends('admin.layouts.master')

@push('custom-css')
    @include('admin.app_title_video.styles.styles')
@endpush

@section('content')
    <div class="page-body">
        <div class="container-xl">
        <form action="{{ route('admin.app_title_video.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <x-button.submit :title="__('Cập nhật')" />
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div id="support-list" class="row">
                            @foreach ($titles as $index => $title)
                                @include('admin.app_title_video.components.card', ['app_title_video' => $title, 'index' => $index])
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('libs-js')
    <!-- button in datatable -->
    <script src="{{ asset('/public/vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('public/libs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/libs/ckeditor/adapters/jquery.js') }}"></script>
    @include('ckfinder::setup')
@endpush

@push('custom-js')
    @include('admin.app_title_video.scripts.scripts')
@endpush