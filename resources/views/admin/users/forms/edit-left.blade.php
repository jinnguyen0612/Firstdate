<div class="col-12 col-md-9">
    <!-- Thông tin đăng nhập -->
    <div class="card mb-3">
        <div class="card-header">
            <h2 class="mb-0">{{ __('Thông tin đăng nhập') }}</h2>
        </div>
        <div class="row card-body">

            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-mail"></i>
                        {{ __('Email đăng nhập') }}:</label>
                    <x-input-email id="emailInput" name="email" :value="$user->email" :disabled="!$isAdmin" />
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-phone"></i>
                        {{ __('Số điện thoại đăng nhập') }}:</label>
                    <x-input-phone name="phone" :value="$user->phone" placeholder="{{ __('Số điện thoại đăng nhập') }}"
                        :disabled="!$isAdmin" />
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
                    <label class="control-label"><i class="ti ti-user-edit"></i>
                        {{ __('Họ và tên') }}:</label>
                    <x-input name="fullname" :value="$user->fullname" placeholder="{{ __('Họ và tên') }}" :disabled="!$isAdmin" />
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-calendar"></i>
                        {{ __('Ngày sinh') }}:</label>
                    <div class="d-flex align-items-center">
                        <x-input class="flex-grow-1 me-4" type="date" name="birthday" :value="isset($user->birthday) ? format_date($user->birthday, 'Y-m-d') : null"
                            :disabled="!$isAdmin" />
                        <span class="col-2"> Tuổi: <b>{{ $age }}</b></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-gender-female"></i>
                        {{ __('Giới tính') }}:</label>
                    <x-select name="gender" :disabled="!$isAdmin">
                        @foreach ($gender as $key => $value)
                            <x-select-option :value="$key" :title="__($value)" :option="$user->gender->value" />
                        @endforeach
                    </x-select>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-gender-male"></i>
                        {{ __('Đối tượng tìm kiếm') }}:</label>
                    <x-select name="looking_for" :disabled="!$isAdmin">
                        @foreach ($lookingFor as $key => $value)
                            <x-select-option :value="$key" :title="__($value)" :option="$user->looking_for->value" />
                        @endforeach
                    </x-select>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-rating-18-plus"></i>
                        {{ __('Tuổi tối thiểu của đối tượng') }}:</label>
                    <x-input type="number" name="min_age_find" :value="$user->min_age_find"
                        placeholder="{{ __('Tuổi tối thiểu của đối tượng') }}" :disabled="!$isAdmin" />
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-rating-18-plus"></i>
                        {{ __('Tuổi tối đa của đối tượng') }}:</label>
                    <x-input type="number" name="max_age_find" :value="$user->max_age_find"
                        placeholder="{{ __('Tuổi tối đa của đối tượng') }}" :disabled="!$isAdmin" />
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-clock"></i>{{ __('Thời gian hẹn hò') }}:</label>
                    <div>
                        <div class="form-selectgroup">
                            @foreach ($datingTime as $key => $value)
                                <label class="form-selectgroup-item">
                                    <input type="checkbox" name="dating_time[]" value="{{ $key }}"
                                        class="form-selectgroup-input"
                                        {{ $user->userDatingTimes->pluck('dating_time')->contains($key) ? 'checked' : '' }}
                                        {{ !$isAdmin ? 'disabled' : '' }} />
                                    <span class="form-selectgroup-label">{{ $value }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><i
                            class="ti ti-heart-handshake"></i>{{ __('Mối quan hệ tìm kiếm') }}:</label>
                    <div>
                        <div class="form-selectgroup">
                            @foreach ($relationships as $key => $value)
                                <label class="form-selectgroup-item">
                                    <input type="checkbox" name="relationship[]" value="{{ $key }}"
                                        class="form-selectgroup-input"
                                        {{ $user->userRelationship->pluck('relationship')->contains($key) == $key ? 'checked' : '' }}
                                        {{ !$isAdmin ? 'disabled' : '' }} />
                                    <span class="form-selectgroup-label">{{ $value }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- address --}}
            <div class="col-12">
                <div class="mb-3">
                    <x-input-pick-address :label="__('Địa chỉ nơi ở hiện tại')" province="province" district="district" :valueProvince="$user->province"
                        :valueDistrict="$user->district" :required="true" :disabled="!$isAdmin" />
                </div>
            </div>

            {{-- Hidden fields --}}
            <input type="hidden" name="province" value="{{ $user->province }}" :disabled="!$isAdmin">
            <input type="hidden" name="district" value="{{ $user->district }}" :disabled="!$isAdmin">
            <input type="hidden" name="lat" value="{{ $user->lat }}" :disabled="!$isAdmin">
            <input type="hidden" name="lng" value="{{ $user->lng }}" :disabled="!$isAdmin">

            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-bookmark"></i>
                        {{ __('Tiểu sử người dùng') }}:</label>
                    <x-textarea maxlength="500" name="description" :required="false" :disabled="!$isAdmin"
                        placeholder="{{ __('Nhập tiểu sử người dùng') }}" icon="ti-message">
                        {{ $user->description }}
                    </x-textarea>
                </div>
            </div>

        </div>
    </div>


</div>
