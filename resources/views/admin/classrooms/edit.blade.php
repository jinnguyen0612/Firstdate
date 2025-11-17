@extends('admin.layouts.master')

@push('libs-css')
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush

@push('custom-css')
    @include('admin.classrooms.styles.styles')
    @include('admin.classrooms.styles.session')
@endpush

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form :action="route('admin.classroom.update')" type="put" :validate="true">
                <x-input type="hidden" name="id" :value="$instance->id" />
                <div class="row justify-content-center">
                    @include('admin.classrooms.forms.edit-left', ['instance' => $instance])
                    @include('admin.classrooms.forms.edit-right', ['instance' => $instance])
                </div>
                <input type="hidden" name="session_data" id="sessionDataInput" :value="$sessions"/>
            </x-form>

            <div class="col-12 mt-3">
                <div class="card px-2 py-3">
                    <div class="card-header">
                        <h2 class="mb-0">{{ __('Buổi học:') }}</h2>
                    </div>
                    <div class="card-body"> 
                        <div id="calendar"></div>
                    </div>

                    <div id="eventModal" class="modal" style="display: none;">
                        <div class="modal-content">
                            <h3>Thông tin buổi học</h3>
                            <p><strong>Ngày:</strong> <span id="modalWeekday"></span></p>

                            <label for="startTime">Giờ bắt đầu:</label>
                            <input readonly type="time" id="startTime">

                            <label for="endTime">Giờ kết thúc:</label>
                            <input readonly type="time" id="endTime">

                            <label for="eventContent">Nội dung:</label>
                            <textarea id="eventContent" rows="3"></textarea>

                            <div class="modal-buttons mt-2">
                                <button class="btn btn-success" id="storeBtn">Lưu</button>
                                <button class="btn btn-secondary" id="cancelBtn">Hủy</button>
                            </div>
                        </div>
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
    @include('admin.classrooms.scripts.scripts')
    <script src='{{ asset('/public/libs/full-calendar/index.global.min.js') }}'></script>
    @include('admin.classrooms.scripts.session')
@endpush
