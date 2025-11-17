@extends('admin.layouts.master')

@push('libs-css')
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush

@push('custom-css')
    @include('admin.classrooms.styles.styles')
    @include('admin.classrooms.styles.schedule')
@endpush


@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form :action="route('admin.classroom.store')" type="post" :validate="true">
                <div class="row justify-content-center">
                    @include('admin.classrooms.forms.create-left')
                    @include('admin.classrooms.forms.create-right')
                </div>
            </x-form>

            
            <div class="col-12 mt-3">
                <div class="card px-2 py-3">
                    <div id="calendar"></div>
        
                    <div id="eventModal" class="modal" style="display: none;">
                        <div class="modal-content">
                            <h3>Thêm thời gian học</h3>
                            <p><strong>Thứ:</strong> <span id="modalWeekday"></span></p>
                            <label for="startTime">Giờ bắt đầu:</label>
                            <input type="time" id="startTime">
                            <label for="endTime">Giờ kết thúc:</label>
                            <input type="time" id="endTime">
                            <div class="modal-buttons">
                                <button class="btn btn-success" id="storeBtn">Lưu</button>
                                <button class="btn btn-danger" id="deleteBtn" style="display:none;">Xóa</button>
                                <button class="btn btn-secondary" id="cancelBtn">Hủy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    @include('admin.classrooms.scripts.scripts')
    @include('admin.classrooms.scripts.schedule')
@endpush
