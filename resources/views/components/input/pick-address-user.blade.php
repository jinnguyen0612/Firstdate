<div class="row mb-2 align-items-end">

    {{-- District + Button & Current Location --}}
    <div class="col-12">
        <div class="input-group form-item">
            <input type="text" {{ $attributes->class(['form-control'])->merge($isRequired()) }}
                id="{{ $name }}"
                name="{{ $name }}"
                value="{{ $value }}"
                readonly
                data-parsley-errors-container="#error{{$name}}" />
            <label for="{{ $name }}" class="form-label mb-0">{{ $label }}</label>

            <button type="button" id="openModalPickAddress"
                    class="btn text-danger fw-normal"
                    data-district="input[name={{$name}}]"
                    data-province="input[name=province]"
                    data-lat="input[name=lat]"
                    data-lng="input[name=lng]"
                    data-address-detail="input[name=address]"
                    data-bs-toggle="modal"
                    data-bs-target="#modalPickAddress">@lang('pickAddress')</button>
        </div>
        <div id="error{{$name}}"></div>
    </div>
</div>


