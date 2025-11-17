<div class="col-12 col-md-9">
    <!-- Thông tin đăng nhập -->
    <div class="card mb-3">
        <div class="card-header">
            <h2 class="mb-0">{{ __('Thông tin đăng nhập') }}</h2>
        </div>
        <div class="row card-body">
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-phone"></i>
                        {{ __('Số điện thoại') }}:</label>
                    <x-input name="phone" :value="old('phone')" placeholder="{{ __('Số điện thoại') }}" />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-mail"></i> {{ __('Email') }}:</label>
                    <x-input-email id="emailInput" name="email" :value="old('email')" />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-key"></i> {{ __('Mật khẩu') }}:</label>
                    <x-input-password name="password" />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-key"></i> {{ __('Xác nhận mật khẩu') }}:</label>
                    <x-input-password name="password_confirmation" data-parsley-equalto="input[name='password']"
                        data-parsley-equalto-message="{{ __('Mật khẩu không khớp.') }}" />
                </div>
            </div>
        </div>
    </div>

    <!-- Thông tin cơ bản -->
    <div class="card mb-3">
        <div class="card-header">
            <h2 class="mb-0">{{ __('Thông tin cơ bản') }}</h2>
        </div>
        <div class="row card-body">
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-user-edit"></i> {{ __('Họ và tên') }}:</label>
                    <x-input name="fullname" :value="old('fullname')" placeholder="{{ __('Họ và tên') }}" />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-calendar"></i> {{ __('Ngày sinh') }}:</label>
                    <x-input type="date" name="birthday" />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-gender-female"></i> {{ __('Giới tính') }}:</label>
                    <x-select name="gender">
                        @foreach ($gender as $key => $value)
                            <x-select-option :value="$key" :title="__($value)" :option="(int) old('gender')" />
                        @endforeach
                    </x-select>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-map-pin"></i> {{ __('Địa chỉ') }}:</label>
                    <x-input name="address" :value="old('address')" placeholder="{{ __('Địa chỉ') }}" />
                </div>
            </div>
        </div>
    </div>
</div>
