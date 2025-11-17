<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ $partner->name }} {{ __(' - Thông tin bàn') }}</h2>
        </div>
        <div class="row card-body">
            <!-- code -->
            <div class="col-md-12 col-sm-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-category"></i> {{ __('Mã bàn') }}:</label>
                    <x-input name="code" :value="$instance->code" disabled/>
                </div>
            </div>
            <!-- name -->
            <div class="col-md-12 col-sm-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-category"></i> {{ __('Tên bàn') }}:</label>
                    <x-input name="name" :value="$instance->name" :required="true" placeholder="{{ __('Tên bàn') }}" />
                </div>
            </div>
            
        </div>
    </div>
</div>
