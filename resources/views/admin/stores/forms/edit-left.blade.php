<div class="col-12 col-md-9">
    <div class="card mb-4">
        <div class="card-header">
            <h2 class="mb-0">{{ __('Thông tin cửa hàng') }}</h2>
        </div>
        <div class="row card-body">
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-building-store"></i> {{ __('Tên cửa hàng') }}:</label>
                    <x-input name="name" :value="$instance->name" placeholder="{{ __('Tên cửa hàng') }}" required />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-info-circle"></i> {{ __('Mô tả chi tiết') }}:</label>
                    <x-input name="description" :value="$instance->description" placeholder="{{ __('Mô tả chi tiết') }}" />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-map-pin"></i> {{ __('Địa chỉ đầy đủ') }}:</label>
                    <x-input name="address" :value="$instance->address" placeholder="{{ __('Địa chỉ đầy đủ') }}" required />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-phone"></i> {{ __('Số điện thoại liên hệ') }}:</label>
                    <x-input name="phone_number" :value="$instance->phone_number" placeholder="{{ __('Số điện thoại liên hệ') }}"
                        required />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-world"></i> {{ __('Link Fanpage Facebook') }}:</label>
                    <x-input name="fanpage_url" :value="$instance->fanpage_url" placeholder="{{ __('Link Fanpage Facebook') }}" />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-mobile"></i> {{ __('Link Zalo') }}:</label>
                    <x-input name="zalo_link" :value="$instance->zalo_link" placeholder="{{ __('Link Zalo OA hoặc cá nhân') }}" />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-message"></i> {{ __('Link Messenger') }}:</label>
                    <x-input name="messenger_link" :value="$instance->messenger_link" placeholder="{{ __('Link Messenger') }}" />
                </div>
            </div>
        </div>
    </div>

    <!-- Thông tin cơ bản -->
    <div class="card mb-4">
        <div class="card-header">
            <h2 class="mb-0">{{ __('Thông tin cơ bản') }}</h2>
        </div>
        <div class="row card-body">
            <!-- Fullname -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-user-edit"></i> {{ __('Họ và tên') }}:</label>
                    <x-input name="fullname" :value="$instance->fullname" :required="true" placeholder="{{ __('Họ và tên') }}" />
                </div>
            </div>
            <!-- birthday -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-calendar"></i> {{ __('Ngày sinh') }}:</label>
                    <x-input type="date" name="birthday" :value="isset($instance->birthday) ? format_date($instance->birthday, 'Y-m-d') : null" />
                </div>
            </div>
            <!-- gender -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-gender-female"></i> {{ __('Giới tính') }}:</label>
                    <x-select name="gender">
                        <x-select-option value="" :title="__('Chọn Giới tính')" />
                        @foreach ($gender as $key => $value)
                            <x-select-option :option="$instance->gender->value" :value="$key" :title="__($value)" />
                        @endforeach
                    </x-select>
                </div>
            </div>
            <!-- address -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-map-pin"></i> {{ __('Địa chỉ') }}:</label>
                    <x-input name="address" :value="$instance->address" placeholder="{{ __('Địa chỉ') }}" />
                </div>
            </div>
            <!-- Max Sound Intensity -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-volume"></i>
                        {{ __('Cường độ âm thanh tối đa') }}:</label>
                    <x-input name="max_sound_intensity" :value="$instance->max_sound_intensity"
                        placeholder="{{ __('Cường độ âm thanh tối đa') }}" />
                </div>
            </div>
            <!-- Max Speed -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-speedometer"></i> {{ __('Tốc độ tối đa') }}:</label>
                    <x-input name="max_speed" :value="$instance->max_speed" placeholder="{{ __('Tốc độ tối đa') }}" />
                </div>
            </div>
        </div>
    </div>

    {{--    <!-- Thông tin Affiliate --> --}}
    {{--    <div class="card mb-4"> --}}
    {{--        <div class="card-header"> --}}
    {{--            <h2 class="mb-0">{{ __('Thông tin Affiliate') }}</h2> --}}
    {{--        </div> --}}
    {{--        <div class="row card-body"> --}}
    {{--            <div class="mb-3"> --}}
    {{--                <input name="is_checked" {{ $instance->is_checked ? 'checked' : '' }} value="1" type="checkbox" id="toggleRegisterAffiliate"> Đăng ký Affiliate --}}
    {{--            </div> --}}
    {{--            <div class="col-12 row {{ $instance->is_checked ? '' : 'd-none' }}" id="infoRegisterAffiliate"> --}}
    {{--                <h3>{{ __('Thông tin đăng ký Affiliate') }}</h3> --}}
    {{--                <div class="mb-3"> --}}
    {{--                    <label for=""><i class="ti ti-building-bank"></i> {{ __('Tên ngân hàng nhận hoa hồng') }}: <span class="text-danger">*</span></label> --}}
    {{--                    <x-input name="bank_name" :value="$instance->bank_name" :placeholder="__('Tên ngân hàng nhận hoa hồng')" /> --}}
    {{--                </div> --}}
    {{--                <div class="mb-3"> --}}
    {{--                    <label for=""><i class="ti ti-user-dollar"></i> {{ __('Tên chủ tài khoản nhận hoa hồng') }}: <span class="text-danger">*</span></label> --}}
    {{--                    <x-input name="bank_account" :value="$instance->bank_account" :placeholder="__('Tên chủ tài khoản nhận hoa hồng')" /> --}}
    {{--                </div> --}}
    {{--                <div class="mb-3"> --}}
    {{--                    <label for=""><i class="ti ti-credit-card-refund"></i> {{ __('Số tài khoản nhận hoa hồng') }}: <span class="text-danger">*</span></label> --}}
    {{--                    <x-input name="bank_account_number" :value="$instance->bank_account_number" :placeholder="__('Số tài khoản nhận hoa hồng')" /> --}}
    {{--                </div> --}}
    {{--                <div class="col-md-6 mb-3"> --}}
    {{--                    <label for=""><i class="ti ti-tag"></i> {{ __('Mã giới thiệu') }}:</label> --}}
    {{--                    <x-input disabled :value="$instance->affiliate_code" /> --}}
    {{--                </div> --}}
    {{--                <div class="col-md-6 mb-3"> --}}
    {{--                    <label for=""><i class="ti ti-currency-dollar"></i> {{ __('Số dư') }}:</label> --}}
    {{--                    <x-input disabled :value="$instance->balance < 0 ? 0 : $instance->balance" /> --}}
    {{--                </div> --}}
    {{--            </div> --}}
    {{--        </div> --}}
    {{--    </div> --}}
</div>

<script>
    document.getElementById('toggleRegisterAffiliate').addEventListener('change', function() {
        var shippingInfoDiv = document.getElementById('infoRegisterAffiliate');
        shippingInfoDiv.classList.toggle('d-none')
    });
</script>
