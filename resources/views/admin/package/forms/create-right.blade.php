@if ($isAdmin)
    <div class="col-12 col-md-3">
        <div class="card mb-3">
            <div class="card-header">
                <i class="ti ti-playstation-circle"></i>
                <span class="ms-2">{{ __('Thao tác') }}</span>
            </div>
            <div class="card-body p-2">
                <x-button.submit :title="__('Thêm')" />
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <span><i class="ti ti-user-check me-2"></i>{{ __('Trạng thái hoạt động') }}</span>
                <div class="mx-2">
                    <label class="heart-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1">
                        <svg viewBox="0 0 33 23" fill="white">
                            <path
                                d="M23.5,0.5 C28.4705627,0.5 32.5,4.52943725 32.5,9.5 C32.5,16.9484448 21.46672,22.5 16.5,22.5 C11.53328,22.5 0.5,16.9484448 0.5,9.5 C0.5,4.52952206 4.52943725,0.5 9.5,0.5 C12.3277083,0.5 14.8508336,1.80407476 16.5007741,3.84362242 C18.1491664,1.80407476 20.6722917,0.5 23.5,0.5 Z">
                            </path>
                        </svg>
                    </label>
                </div>
            </div>
        </div>
    </div>
@endif
