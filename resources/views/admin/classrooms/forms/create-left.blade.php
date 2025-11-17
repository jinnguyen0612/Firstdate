<div class="col-12 col-md-9">
    <!-- Thông tin lớp học -->
    <div class="card mb-3">
        <div class="card-header">
            <h2 class="mb-0">{{ __('Thông tin lớp học') }}</h2>
        </div>
        <div class="row card-body">
            <!-- Tên lớp học -->
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-book"></i> {{ __('Tên lớp học') }}:</label>
                    <x-input name="name" :value="old('name')" placeholder="{{ __('Tên lớp học') }}" />
                </div>
            </div>

            <!-- Loại lớp học -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-layers"></i> {{ __('Loại lớp học') }}:</label>
                    <x-select id="type" name="type">
                        @foreach ($classroomType as $value => $type)
                            <x-select-option :value="$value" :title="__($type)" :selected="old('type') == $value"/>
                        @endforeach
                    </x-select>
                </div>
            </div>

            <!-- Số lượng học sinh tối đa -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-users"></i>
                        {{ __('Số lượng học sinh tối đa') }}:</label>
                    <x-input id="max_student" name="max_students" type="number" :value="old('max_students')"
                        placeholder="{{ __('Tối đa học sinh') }}" />
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="mb-3">
                        <label class="control-label" for="">{{ __('Ngày bắt đầu') }}</label>
                        <x-input type="date" name="start_date" :required="true" :value="old('start_date')"/>
                </div>
            </div>
           
            <!-- Số lượng buổi học -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-numbers"></i>
                        {{ __('Số lượng buổi học') }}:</label>
                    <x-input id="session" name="session_qty" type="number" :value="old('session_qty')"
                        placeholder="{{ __('Số buổi học') }}" />
                </div>
            </div>

            <!-- Giáo viên -->
            <div style="display: block" id="teacher-select" class="col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-user"></i> {{ __('Giáo viên phụ trách') }}:</label>
                    <x-select style="width: 100%;" name="teacher_id" class="select2-bs5-ajax" :data-url="route('admin.search.select.teacher')" id="teacher_id">
                    </x-select>
                </div>
            </div>
            
            <!-- Học sinh -->
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-user-plus"></i> {{ __('Danh sách học sinh') }}:</label>
                    <x-select style="width: 100%;" name="student_id[]" class="select2-bs5-ajax" :data-url="route('admin.search.select.student')" id="student_id" multiple>
                    </x-select>
                </div>
            </div>
        </div>
        
        <input type="hidden" name="event_data" id="eventDataInput" value="{{ old('event_data') }}"/>
    </div>
</div>
