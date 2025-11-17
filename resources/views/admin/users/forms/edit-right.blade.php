<div class="col-12 col-md-3">
    @if($isAdmin)
        <div class="card mb-3">
            <div class="card-header">
                <i class="ti ti-playstation-circle"></i>
                <span class="ms-2">{{ __('Thao tác') }}</span>
            </div>
            <div class="card-body d-flex justify-content-between p-2">
                <x-button.submit :title="__('Cập nhật')" />
                <x-button.modal-delete
                    data-route="{{ route('admin.user.delete', $user->id) }}"
                    :title="__('Xóa')" />
            </div>
        </div>
    @endif
    <div class="card mb-3">
        <div class="card-header">
            <span><i
                    class="ti ti-user-check me-2"></i>{{ __('Hiển thị hồ sơ') }}</span>
            <div class="mx-2">
                <label class="heart-switch">
                    <input type="hidden" name="is_hide" value="1">
                    <input type="checkbox" name="is_hide" value="0" {{ !$isAdmin ? 'disabled' : '' }}
                        {{ $user->is_hide == 0 ? 'checked' : '' }}>
                    <svg viewBox="0 0 33 23" fill="white">
                        <path
                            d="M23.5,0.5 C28.4705627,0.5 32.5,4.52943725 32.5,9.5 C32.5,16.9484448 21.46672,22.5 16.5,22.5 C11.53328,22.5 0.5,16.9484448 0.5,9.5 C0.5,4.52952206 4.52943725,0.5 9.5,0.5 C12.3277083,0.5 14.8508336,1.80407476 16.5007741,3.84362242 C18.1491664,1.80407476 20.6722917,0.5 23.5,0.5 Z">
                        </path>
                    </svg>
                </label>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="ti ti-photo"></i>
            <span class="ms-2">@lang('avatar')</span>
        </div>
        <div class="card-body p-2">
            @if($isAdmin)
                <x-input-image-ckfinder name="avatar" showImage="avatar" class="img-fluid" :value="$user->avatar" />
            @else
                <img 
                    src="{{ asset($user->avatar) }}" style="width: 100%">
            @endif
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <i class="ti ti-photo"></i>
            <span class="ms-2">{{ __('Thư viện ảnh') }}</span>
        </div>
        <div class="card-body p-2">
            @if($isAdmin)
                <x-input-gallery-ckfinder name="thumbnails" type="multiple" :value="$user->thumbnails" />
            @else
                @if($user->thumbnails)
                <div class="row">
                    @foreach($user->thumbnails as $item)
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-3">
                        <img src="{{ asset($item) }}" width="100%">
                    </div>
                    @endforeach
                </div>
                @endif
            @endif
        </div>
    </div>
</div>