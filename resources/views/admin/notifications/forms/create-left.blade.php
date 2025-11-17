<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <div class="col-12">
                <div class="mb-3">
                    <label for="notification_object"><i class="ti ti-bell"></i> {{ __('Đối tượng nhận') }} <span
                            class="text-danger">*</span></label>
                    <x-select name="notification_object" id="notification_object" class="form-select">
                        @foreach (\App\Enums\Notification\NotificationObject::cases() as $case)
                            <x-select-option value="{{ $case->value }}" :option="old('notification_object')" :title="$case->description()" />
                        @endforeach
                    </x-select>
                </div>
            </div>

            <div class="col-12" id="user_select" style="display: none;">
                <div class="mb-3">
                    <label for="user_ids"><i class="ti ti-user"></i> {{ __('Người dùng') }}</label>
                    <x-select name="user_ids[]" id="user_ids" class="form-select select2-bs5-ajax"
                        :data-url="route('admin.search.select.user')" multiple></x-select>
                    <small class="text-muted">
                        <i class="ti ti-info-circle text-warning me-1"></i>
                        {{ __('Nếu gửi "Tất cả" thì để trống mục này.') }}
                    </small>
                </div>
            </div>

            <div class="col-12" id="partner_select" style="display: none;">
                <div class="mb-3">
                    <label for="partner_ids"><i class="ti ti-user-cog"></i> {{ __('Đối tác') }}</label>
                    <x-select name="partner_ids[]" id="partner_ids" class="form-select select2-bs5-ajax"
                        :data-url="route('admin.search.select.partner')" multiple></x-select>
                    <small class="text-muted">
                        <i class="ti ti-info-circle text-warning me-1"></i>
                        {{ __('Nếu gửi "Tất cả" thì để trống mục này.') }}
                    </small>
                </div>
            </div>

            <!-- title -->
            <div class="col-12">
                <div class="mb-3">
                    <label for=""><i class="ti ti-pencil"></i> {{ __('Tiêu đề') }} <span
                            class="text-danger">*</span></label>
                    <x-input name="title" :value="old('title')" :placeholder="__('Tiêu đề')" />
                </div>
            </div>

            <!-- short_message -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-message"></i>
                        {{ __('Mô tả ngắn') }} <span class="text-danger">*</span></label>
                    <x-input name="short_message" :value="old('short_message')" :placeholder="__('Mô tả ngắn')" />
                </div>
            </div>

            <!-- message -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-message"></i>
                        {{ __('Nội dung thông báo') }} <span class="text-danger">*</span></label>
                    <textarea name="message" class="ckeditor visually-hidden">
                        {{ old('message') }}
                    </textarea>
                </div>
            </div>
        </div>
    </div>
</div>
