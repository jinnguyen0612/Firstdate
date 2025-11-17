<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ $partner->name }} {{ __('- Thông tin bàn') }}</h2>
        </div>
        <div class="row card-body">
            <!-- name -->
            <div class="col-md-12 col-sm-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-category"></i>
                        {{ __('Tên bàn') }}: <span class="text-danger">*</span></label>
                    <x-input name="name" :value="old('name')" :required="true"
                        placeholder="{{ __('Tên bàn') }}" />
                </div>
            </div>
        </div>
    </div>
</div>
