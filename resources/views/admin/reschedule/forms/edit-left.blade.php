<div class="col-12 col-md-9">
    <!-- Thông tin lớp học -->
    <div class="card mb-3">
        <div class="card-header">
            <h2 class="mb-0">{{ __('Chỉnh sửa lớp học') }}</h2>
        </div>
        <div class="row card-body">

            <!-- Tên lớp học -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-book"></i> {{ __('Tên lớp học') }}:</label>
                    <x-input name="name" :value="old('name', $instance->name)" placeholder="{{ __('Tên lớp học') }}" />
                </div>
            </div>

            <!-- Loại lớp học -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-layers"></i> {{ __('Loại lớp học') }}:</label>
                    <x-select name="type">
                        @foreach ($classroomType as $value => $type)
                            <x-select-option :value="$value" :title="__($type)" :selected="$instance->type === $value"/>
                        @endforeach
                    </x-select>
                </div>
            </div>

            <!-- Số lượng học sinh tối đa -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-users"></i>
                        {{ __('Số lượng học sinh tối đa') }}:</label>
                    <x-input name="max_students" type="number" :value="old('max_students', $instance->max_students)"
                        placeholder="{{ __('Tối đa học sinh') }}" />
                </div>
            </div>
            
            <div class="col-md-6 col-12">
                <div class="mb-3">
                        <label class="control-label" for="">{{ __('Ngày bắt đầu') }}</label>
                        <x-input readonly type="date" name="start_date" :required="true" :value="old('start_date',\Carbon\Carbon::parse($instance->start_date)->format('Y-m-d'))"/>
                </div>
            </div>
            
            <!-- Số lượng buổi học -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-numbers"></i>
                        {{ __('Số lượng buổi học') }}:</label>
                    <x-input readonly name="session_qty" type="number" :value="old('session_qty', $instance->session_qty)"
                        placeholder="{{ __('Số buổi học') }}" />
                </div>
            </div>

            <!-- Giáo viên -->
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-user"></i> {{ __('Giáo viên phụ trách') }}:</label>
                    <x-select name="teacher_id" class="select2-bs5-ajax" :data-url="route('admin.search.select.teacher')" id="teacher_id">
                        <x-select-option :value="$instance->teacher->id" 
                            :title="'Họ tên: ' . $instance->teacher->fullname . ' | SDT: ' . $instance->teacher->phone_verified . ' | Email: ' . $instance->teacher->email"
                            :selected="$instance->teacher_id" />
                    </x-select>
                </div>
            </div>

            <!-- Học sinh -->
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-user-plus"></i> {{ __('Danh sách học sinh') }}:</label>
                    <x-select style="width: 100%;" name="student_id[]" class="select2-bs5-ajax" :data-url="route('admin.search.select.student')" id="student_id" multiple>
                        @foreach ($instance->students as $student)
                            <x-select-option :value="$student->id" 
                                :title="'Họ tên: ' . $student->fullname . ' | SDT: ' . $student->phone_verified . ' | Email: ' . $student->email"
                                :selected="$student->id" />
                        @endforeach
                    </x-select>
                </div>
            </div>
        </div>
    </div>
</div>
