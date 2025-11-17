<div class="col-12 col-md-3">
    @if($isAdmin)
    <div class="card mb-3">
        <div class="card-header">
            <i class="ti ti-playstation-circle"></i>
            <span class="ms-2">{{ __('Thao tác') }}</span>
        </div>
        <div class="card-body d-flex justify-content-between p-2">
            <x-button.submit :title="__('Cập nhật')" />
            <x-button.modal-delete data-route="{{ route('admin.user.delete', $user->id) }}" :title="__('Xóa')" />
        </div>
    </div>
    @endif
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
                <x-input-gallery-ckfinder name="gallery" type="multiple" :value="$user->gallery" />
            @else
                @if($user->gallery)
                <div class="row">
                    @foreach($user->gallery as $item)
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
