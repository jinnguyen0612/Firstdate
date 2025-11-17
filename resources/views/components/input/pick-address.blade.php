<div class="row mb-2 align-items-end">
    {{-- Province --}}
    <div class="col-md-6">
        <label class="form-label">@lang('Tỉnh/Thành phố')</label>
        <input type="text" {{ $attributes->class(['form-control'])->merge($isRequired()) }}
            name="{{ $province }}"
            value="{{ $valueProvince }}"
            readonly
            data-parsley-errors-container="#error{{$province}}" />
        <div id="errorProvince"></div>
    </div>

    {{-- District + Button & Current Location --}}
    <div class="col-md-6">
        <div class="d-flex justify-content-between">
            <label class="form-label mb-0">@lang('Quận/Huyện')</label>
            <div id="getCurrentLocation" class="text-danger d-flex align-items-center small">
                <div class="spinner-border text-danger me-1" role="status" style="display: none;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span class="cursor-pointer">@lang('useCurrentLocation')</span>
            </div>
        </div>
        <div class="input-group">
            <input type="text" {{ $attributes->class(['form-control'])->merge($isRequired()) }}
                name="{{ $district }}"
                value="{{ $valueDistrict }}"
                readonly
                data-parsley-errors-container="#error{{$district}}" />
            <button type="button" id="openModalPickAddress"
                    class="btn text-danger fw-normal"
                    data-input="input[name=province]"
                    data-district="input[name=district]"
                    data-lat="input[name=lat]"
                    data-lng="input[name=lng]"
                    data-address-detail="input[name=address_detail]"
                    data-bs-toggle="modal"
                    data-bs-target="#modalPickAddress">@lang('pickAddress')</button>
        </div>
        <div id="error{{$province}}"></div>
        <div id="error{{$district}}"></div>
    </div>
</div>


