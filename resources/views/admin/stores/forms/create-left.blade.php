<div class="col-12 col-md-9">
    {{-- Form 1: Thông tin cửa hàng --}}
    <div class="card mb-3">
        <div class="card-header">
            <h2 class="mb-0">{{ __('Thông tin cửa hàng') }}</h2>
        </div>
        <div class="row card-body">
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label required"><i class="ti ti-building-store"></i>
                        {{ __('Tên cửa hàng') }}:</label>
                    <x-input name="name" :value="old('name')" placeholder="{{ __('Tên cửa hàng') }}" required />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-info-circle"></i>
                        {{ __('Mô tả chi tiết') }}:</label>
                    <x-input name="description" :value="old('description')" placeholder="{{ __('Mô tả chi tiết') }}" />
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label required"><i class="ti ti-map-2"></i>
                        {{ __('Khu vực') }}:</label>
                    <select name="area_id" class="form-select" required>
                        <option value="">{{ __('Chọn khu vực') }}</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                {{ $area->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Thêm trường Email --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label required"><i class="ti ti-mail"></i>
                        {{ __('Email') }}:</label>
                    <x-input type="email" name="email" :value="old('email')"
                        placeholder="{{ __('Nhập địa chỉ email') }}" required />
                </div>
            </div>

            {{-- Thêm trường Password --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label required"><i class="ti ti-lock"></i>
                        {{ __('Mật khẩu') }}:</label>
                    <x-input type="password" name="password" placeholder="{{ __('Nhập mật khẩu') }}" required />
                </div>
            </div>

            {{-- Thêm trường Confirm Password --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label required"><i class="ti ti-lock-check"></i>
                        {{ __('Xác nhận mật khẩu') }}:</label>
                    <x-input type="password" name="password_confirmation" placeholder="{{ __('Nhập lại mật khẩu') }}"
                        required />
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label required"><i class="ti ti-map-pin"></i>
                        {{ __('Địa chỉ đầy đủ') }}:</label>
                    <x-input name="address" :value="old('address')" placeholder="{{ __('Địa chỉ đầy đủ') }}" required />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label required"><i class="ti ti-phone"></i>
                        {{ __('Số điện thoại liên hệ') }}:</label>
                    <x-input name="phone_number" :value="old('phone_number')" placeholder="{{ __('Số điện thoại liên hệ') }}"
                        required />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-world"></i>
                        {{ __('Link Fanpage Facebook') }}:</label>
                    <x-input name="fanpage_url" :value="old('fanpage_url')" placeholder="{{ __('Link Fanpage Facebook') }}" />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-mobile"></i>
                        {{ __('Link Zalo') }}:</label>
                    <x-input name="zalo_link" :value="old('zalo_link')" placeholder="{{ __('Link Zalo OA hoặc cá nhân') }}" />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-message"></i>
                        {{ __('Link Messenger') }}:</label>
                    <x-input name="messenger_link" :value="old('messenger_link')" placeholder="{{ __('Link Messenger') }}" />
                </div>
            </div>
        </div>
    </div>

    {{-- Form 2: Upload hình ảnh --}}
    <div class="card mb-3">
        <div class="card-header">
            <h2 class="mb-0">{{ __('Hình ảnh cửa hàng') }}</h2>
        </div>
        <div class="card-body">
            <div id="images-container">
                <div class="mb-3 image-group">
                    <div class="preview-container mb-2" style="display: none;">
                        <img src="" class="img-preview img-fluid rounded" style="max-height: 150px;">
                    </div>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="input-group">
                                <input type="file" class="form-control store-image" name="store_images[]"
                                    accept="image/*">
                                <button type="button" class="btn btn-danger remove-image" style="display: none;">
                                    <i class="ti ti-x"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-8 mb-2">
                            <input type="text" class="form-control" name="captions[]"
                                placeholder="{{ __('Chú thích ảnh (tùy chọn)') }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <input type="number" class="form-control display-order" name="display_orders[]"
                                placeholder="{{ __('Thứ tự') }}" value="0" min="0">
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary btn-sm mt-2" id="add-image">
                <i class="ti ti-plus"></i> {{ __('Thêm ảnh') }}
            </button>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .preview-container {
            position: relative;
            text-align: center;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            cursor: move;
        }

        .image-group {
            border: 1px solid #dee2e6;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .remove-image {
            width: 40px;
        }

        .display-order {
            width: 80px;
        }

        .required:after {
            content: " *";
            color: red;
        }
    </style>
@endpush
