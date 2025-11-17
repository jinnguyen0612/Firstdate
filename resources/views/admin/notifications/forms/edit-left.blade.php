@php
    $receiver = $notification->partner_id ? $notification->partner : $notification->user;
    $name = $notification->partner_id ? $receiver->name : $receiver->fullname;
    $receiverName = sprintf('%s | Email: %s | SĐT: %s', $name, $receiver->email, $receiver->phone);
@endphp
<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- title -->
            <div class="col-12">
                <div class="mb-3">
                    <label for=""><i class="ti ti-user"></i> {{ __('Người nhận') }}</label>
                    <input type="text" class="form-control bg-light text-body" value="{{ $receiverName }}" disabled />
                </div>
            </div>

            <!-- title -->
            <div class="col-12">
                <div class="mb-3">
                    <label for=""><i class="ti ti-pencil"></i> {{ __('Tiêu đề') }} <span
                            class="text-danger">*</span></label>
                    <x-input :value="$notification->title" name="title" :required="true" :placeholder="__('Tiêu đề')" />
                </div>
            </div>

            <!-- short_message -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-message"></i>
                        {{ __('Mô tả ngắn') }} <span class="text-danger">*</span></label>
                    <x-input name="short_message" :value="$notification->short_message" :placeholder="__('Mô tả ngắn')" />
                </div>
            </div>

            <!-- message -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-message"></i>
                        {{ __('Nội dung thông báo') }} <span class="text-danger">*</span></label>
                    <textarea name="message" class="ckeditor visually-hidden">{{ $notification->message }}</textarea>
                </div>
            </div>

        </div>
    </div>
</div>
