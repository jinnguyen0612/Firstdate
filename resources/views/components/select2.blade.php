<select name="{{ $name }}" class="form-select select2 {{ $class }}" {{ $required ? 'required' : '' }}
    data-placeholder="{{ $placeholder }}" data-ajax--url="{{ $dataAjaxUrl }}" data-ajax--data="{{ $dataAjaxData }}"
    {{ $attributes }}>
    <option value="">{{ $placeholder }}</option>
    {{ $slot }}
</select>

@once
    @push('libs-css')
        <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
    @endpush

    @push('libs-js')
        <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('/public/libs/select2/dist/js/i18n/' . trans()->getLocale() . '.js') }}"></script>
    @endpush

    @push('custom-js')
        <script>
            $(document).ready(function() {
                $('.select2').each(function() {
                    $(this).select2({
                        theme: 'bootstrap-5',
                        ajax: {
                            url: $(this).data('ajax--url'),
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                var data = {
                                    term: params.term,
                                    page: params.page || 1
                                };

                                // Thêm data từ data-ajax--data nếu có
                                var extraData = $(this).data('ajax--data');
                                if (extraData) {
                                    try {
                                        var fn = new Function('d', 'return ' + extraData);
                                        data = fn(data);
                                    } catch (e) {
                                        console.error('Error parsing data-ajax--data:', e);
                                    }
                                }

                                return data;
                            },
                            processResults: function(data, params) {
                                params.page = params.page || 1;
                                return {
                                    results: data.results,
                                    pagination: {
                                        more: false
                                    }
                                };
                            },
                            cache: true
                        },
                        minimumInputLength: 0,
                        allowClear: true
                    });
                });
            });
        </script>
    @endpush
@endonce
