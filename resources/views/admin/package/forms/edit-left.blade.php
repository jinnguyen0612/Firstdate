<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin Gói') }}</h2>
        </div>
        <div class="row card-body">
            <!-- name -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-package"></i>
                        {{ __('Tên gói') }}: <span class="text-danger">*</span></label>
                    <x-input name="name" :value="old('name', $package->name)" :required="true" placeholder="{{ __('Tên gói') }}" />
                </div>
            </div>

            <!-- price -->
            <div class="col-12 col-md-6 col-sm-6">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-coin"></i>
                        {{ __('Giá tiền (tim)') }}: <span class="text-danger">*</span></label>
                    <x-input-number :disabled="!$isAdmin" name="price" :value="old('price', $package->price)" :required="true"
                        placeholder="{{ __('Giá tiền') }}" />
                </div>
            </div>

            <!-- discount_price -->
            <div class="col-12 col-md-6 col-sm-6">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-coin"></i>
                        {{ __('Giá tiền sau giảm giá') }}:</label>
                    <x-input-number :disabled="!$isAdmin" name="discount_price" :value="old('discount_price', $package->discount_price)"
                        placeholder="{{ __('Giá tiền sau giảm giá') }}" />
                </div>
            </div>

            <!-- available_days -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-calendar"></i>
                        {{ __('Số ngày khả dụng') }}: <span class="text-danger">*</span></label>
                    <x-input-number :disabled="!$isAdmin" name="available_days" :value="old('available_days', $package->available_days)"
                        placeholder="{{ __('Số ngày khả dụng') }}" />
                </div>
            </div>

            <!-- description -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-file-description"></i>
                        {{ __('Mô tả') }}: </label>
                    <x-textarea maxlength="500" name="description" :value="old('description')" :required="false"
                        placeholder="{{ __('Nhập tiểu sử người dùng') }}" icon="ti-message" rows="5">
                        {{ $package->description }}
                    </x-textarea>
                </div>
            </div>
        </div>
    </div>
</div>
