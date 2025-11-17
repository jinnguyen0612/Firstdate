<div class="row mt-3 mb-3">
    <div class="col-12">
        <div class="mb-3 text-center">
            <div class="container-image">
                <div class="group-image">
                    <label class="picture" for="picture__input" tabIndex="0">
                        <span class="picture__image"></span>
                    </label>

                    <input type="file" name="avatar" id="picture__input"
                        data-default="{{ asset($currentPartner->avatar??'assets/images/anhthumb.jpg') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 px-3">
        <div class="mb-3">
            <div class="form-item">
                <input type="text" id="name" autocomplete="off" required value="{{ $currentPartner->fullname }}">
                <label for="name">Tên</label>
            </div>
        </div>
        <div class="mb-3">
            <div class="form-item">
                <input type="text" id="email" autocomplete="off" value="{{ $currentPartner->email }}" disabled>
                <label for="email">Email</label>
            </div>
        </div>
        <div class="mb-3">
            <div class="form-item">
                <input type="text" id="phone" autocomplete="off" value="{{ $currentPartner->phone }}" disabled>
                <label for="phone">Số điện thoại</label>
            </div>
        </div>
        
        <div class="fixed-bottom">
            <div class="container btn-update-profile">
                <button class="btn btn-default" type="button" id="btnUpdateProfile">
                    Cập nhật
                </button>
            </div>
        </div>

    </div>
</div>

@push('custom-js')
    @include('admin.layouts.modal.modal-user-address')
    @include('admin.scripts.google-map-user-input')
@endpush
