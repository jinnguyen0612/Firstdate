<section id="photos">
    <div id="imageContextMenu" class="dropdown-menu" style="position:absolute; display:none;">
        <a class="dropdown-item" href="#" id="showImageBtn"><i class="ti ti-eye"></i> Xem ảnh</a>
        <a class="dropdown-item" href="#" id="deleteImageBtn"><i class="ti ti-trash"></i> Xóa ảnh</a>
    </div>

    <div class='image-upload-container'>
        <input name='images[]' type='file' accept="image/x-png, image/jpeg" multiple style="opacity: 0;" />
        <div class="image-previews">
            <div class="image">
                <div>+</div>
            </div>
        </div>
    </div>
    @if (session('gallery'))
        @foreach (session('gallery') as $img)
            <img class="img-fluid" onclick="showFullImage(this)" src="{{ asset($img) }}">
        @endforeach
    @endif
    @if ($currentPartner->gallery)
        @foreach ($currentPartner->gallery as $item)
            <img class="img-fluid" onclick="showFullImage(this)" src="{{ asset($item) }}">
        @endforeach
    @endif
</section>
<div class="fixed-bottom">
    <div class="container btn-update-profile">
        <button class="btn btn-default" type="button" id="btnUpdateGallery">
            Cập nhật
        </button>
    </div>
</div>
