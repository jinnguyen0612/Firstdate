@push('custom-css')
    <style>
        .pac-container {
            z-index: 99999999 !important;
        }
    </style>
@endpush

<div class="modal modal-blur fade" id="modalPickAddress" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('pickAddress')</h5>
                <button type="button" class="btn-close cancel-pick-address" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="pickPlace" class="form-label">@lang('pickAddress')</label>
                    <x-input name="pickPlace" id="pickPlace" />
                </div>
                <div id="pickedAddress" class="mb-3">
                    <span><strong>@lang('pickedAddress')</strong></span>:
                    <span class="show-text"></span>
                </div>
                <div id="showMap" class="w-100" style="height: 400px"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary me-auto cancel-pick-address"
                    data-bs-dismiss="modal">@lang('cancel')</button>
                <button type="button" id="confirmPickAddress" class="btn btn-danger"
                    data-bs-dismiss="modal">@lang('oke')</button>
            </div>
        </div>
    </div>
</div>

@push('custom-js')
    @push('custom-js')
        <script>
            var map, marker, autocomplete, currentTriggerBtn = null;

            function initMap() {
                map = new google.maps.Map(document.getElementById('showMap'), {
                    center: {
                        lat: 10.762622,
                        lng: 106.660172
                    },
                    zoom: 12,
                    gestureHandling: "cooperative"
                });

                marker = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    visible: false
                });

                autocomplete = new google.maps.places.Autocomplete(document.getElementById('pickPlace'));
                autocomplete.bindTo('bounds', map);

                autocomplete.addListener('place_changed', function() {
                    var place = autocomplete.getPlace();
                    if (!place.geometry) {
                        console.error("Place not found:", place.name);
                        return;
                    }

                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);
                    }

                    marker.setPosition(place.geometry.location);
                    marker.setVisible(true);

                    var address = place.formatted_address || '';
                    var district = getDistrictFromComponents(place.address_components);

                    $('#pickedAddress .show-text').text(address);
                    $('#pickedAddress').data('district', district);
                });

                marker.addListener('dragend', function() {
                    geocodePosition(marker.getPosition());
                });
            }

            function geocodePosition(pos) {
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    location: pos
                }, function(responses, status) {
                    if (status === google.maps.GeocoderStatus.OK && responses[0]) {
                        var address = responses[0].formatted_address;
                        var district = getDistrictFromComponents(responses[0].address_components);

                        $('#pickedAddress .show-text').text(address);
                        $('#pickedAddress').data('district', district);
                    } else {
                        $('#pickedAddress .show-text').text('@lang('cannotDetermineAddress')');
                        $('#pickedAddress').data('district', '');
                    }
                });
            }

            function getDistrictFromComponents(components) {
                var district = '';
                if (components) {
                    components.forEach(function(c) {
                        if (c.types.includes("administrative_area_level_2")) {
                            district = c.long_name;
                        }
                    });
                }
                return district;
            }

            // Khi nhấn nút mở modal => lưu lại button đang bấm
            $(document).on('click', '#openModalPickAddress', function() {
                currentTriggerBtn = $(this);
            });

            // Khi xác nhận chọn địa chỉ
            $(document).on('click', '#confirmPickAddress', function() {
                if (!currentTriggerBtn) return;

                var lat = marker.getPosition() ? marker.getPosition().lat() : '';
                var lng = marker.getPosition() ? marker.getPosition().lng() : '';
                var address = $('#pickedAddress .show-text').text();
                var district = $('#pickedAddress').data('district') || '';

                $(currentTriggerBtn.data('lat')).val(lat);
                $(currentTriggerBtn.data('lng')).val(lng);
                $(currentTriggerBtn.data('address-detail')).val(address);

                if (currentTriggerBtn.data('district')) {
                    $(currentTriggerBtn.data('district')).val(district);
                }
            });

            // Load Google Maps API nếu chưa load
            if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
                var script = document.createElement('script');
                script.async = true;
                document.head.appendChild(script);
            } else {
                initMap();
            }
        </script>
    @endpush
@endpush
