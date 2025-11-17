<div class="col-12 col-md-3">
    <div class="card mb-3">
        <div class="card-header">
            <span><i class="ti ti-playstation-circle me-2"></i>{{ __('Thao tác') }}</span>
        </div>
        <div class="card-body p-2">
            <div class="d-flex align-items-center h-100 gap-2">
                <x-button.submit :title="__('Lưu')" name="submitter" value="save" />
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <i class="ti ti-photo"></i>
            <span class="ms-2">Hình ảnh</span>
        </div>
        <div class="card-body p-2">
            <x-input-image-ckfinder name="image" showImage="featureImage" />
        </div>
    </div>
</div>
