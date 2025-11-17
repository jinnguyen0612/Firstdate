@extends('admin.layouts.master')

@push('custom-css')
    @include('admin.reject_reason.styles.styles')
@endpush

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <form action="{{ route('admin.reject_reason.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <x-button.submit :title="__('Cập nhật')" />
                    </div>
                </div>
                <div class="col-12 question-form">
                    <div class="card mb-3">
                        <div class="card-body p-2">
                            <div id="choices-container"></div>
                            <button type="button" id="add-choice-btn"
                                style="{{ !$isAdmin ? 'opacity: 0; pointer-events: none;' : '' }}">Thêm lựa chọn</button>
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
    @include('admin.reject_reason.scripts.scripts')
@endpush
