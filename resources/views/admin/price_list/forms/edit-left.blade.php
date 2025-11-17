<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin giá') }}</h2>
        </div>
        <div class="row card-body">
            <!-- price -->
            <div class="col-md-12 col-sm-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-cash-banknote"></i> {{ __('Giá tiền') }}:</label>
                    <x-input-number class="currency-input" name="price" :value="$priceList->price" :required="true" placeholder="{{ __('Giá tiền') }}" />
                </div>
            </div>
            
            <!-- value -->
            <div class="col-md-12 col-sm-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-coin"></i> {{ __('Số tim nhận được') }}:</label>
                    <x-input-number name="value" :value="$priceList->value" :required="true" placeholder="{{ __('Số tim nhận được') }}" />
                </div>
            </div>
            
        </div>
    </div>
</div>
