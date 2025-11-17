<div class="col-12 col-md-3">
    <div class="card mb-3">
        <div class="card-header">
            <i class="ti ti-playstation-circle"></i>
            <span class="ms-2">{{ __('Thao tác') }}</span>
        </div>
        <div class="card-body d-flex justify-content-between p-2">
            <x-button.submit :title="__('Cập nhật')" />
            <x-button.modal-delete data-route="{{ route('admin.classroom.delete', $instance->id) }}" :title="__('Xóa')" />
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <span><i class="ti ti-user-check me-2"></i>{{ __('Lớp đã đủ học sinh') }}</span>
        </div>
        <div class="card-body p-2">
            <input disabled type="hidden" name="is_full" value="0">
            <x-input-switch disabled name="is_full" value="1" :label="__('Đã đủ học sinh??')" :checked="$instance->is_full == 1" />
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            {{ __('Trạng thái lớp học') }}
        </div>
        <div class="card-body p-2">
            <x-select name="status" :required="true">
                            @foreach ($classroomStatus as $value => $key)
                                <x-select-option :value="$value" :title="$key" :selected="$instance->status === $value"/>
                            @endforeach
            </x-select>
        </div>
    </div>
</div>
