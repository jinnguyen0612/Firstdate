<div class="col-12 col-md-9">
    <div class="card mb-3">
        <div class="card-header">
            <i class="ti ti-map-2"></i>
            <span class="ms-2">{{ __('Khu vực') }}</span>
        </div>
        <div class="card-body p-2">
            <x-input name="name" :value="old('name')" placeholder="{{ __('Tên khu vực') }}" required />
        </div>
    </div>
</div>
