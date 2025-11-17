<script src="{{ asset('public/user/assets/js/jquery.js') }}"></script>
<script src="{{ asset('public/user/assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/user/assets/fotorama-4.6.4/fotorama.js') }}"></script>
<script src="{{ asset('public/libs/jquery-toast-plugin/jquery.toast.min.js') }}"></script>

<!-- datatables -->
<script src="{{ asset('/public/libs/datatables/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('/public/libs/datatables/plugins/bs5/js/dataTables.bootstrap5.min.js') }}"></script>

<script src="{{ asset('/public/libs/datatables/plugins/buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/public/libs/datatables/plugins/buttons/js/buttons.bootstrap5.min.js') }}"></script>

<script src="{{ asset('/public/libs/datatables/plugins/responsive/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ asset('/public/libs/datatables/plugins/responsive/js/responsive.bootstrap5.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stack('libs-js')
<script type="module" src="{{ asset('public/admin/assets/js/i18n.js') }}"></script>
<script src="{{ asset('public/admin/assets/js/setup.js') }}"></script>
<script src="{{ asset('public/user/assets/js/home.js') }}"></script>
<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places&language=vi&callback=initMaps"
    async defer></script>
<script>
    function initMaps() {
        try {
            if (typeof initMap === 'function') {
                initMap();
            }
            if (typeof initEndMap === 'function') {
                initEndMap();
            }
        } catch (error) {
            handleAjaxError();
            window.location.reload();
        }
    }
</script>

@stack('custom-js')
<script>
    function showFullImage(imgElement) {
        const modal = document.getElementById('image-modal');
        const fullImage = modal.querySelector('img');
        fullImage.src = imgElement.src; // hoặc dùng full URL nếu ảnh thu nhỏ khác ảnh gốc
        modal.style.display = 'flex';
    }

    function hideFullImage() {
        document.getElementById('image-modal').style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('image-modal').addEventListener('click', hideFullImage);
    });
</script>

<script>
    function formatTimeDifference(inputTime) {
        const now = new Date();
        const input = new Date(inputTime);
        const diffMs = now - input;

        const minuteMs = 60 * 1000;
        const hourMs = 60 * minuteMs;
        const dayMs = 24 * hourMs;

        const minutes = Math.floor(diffMs / minuteMs);
        const hours = Math.floor(diffMs / hourMs);
        const days = Math.floor(diffMs / dayMs);

        if (minutes < 60) {
            return `${minutes} phút trước`;
        } else if (hours < 24) {
            return `${hours} giờ trước`;
        } else if (days <= 7) {
            return `${days} ngày trước`;
        } else {
            const hh = String(input.getHours()).padStart(2, '0');
            const mm = String(input.getMinutes()).padStart(2, '0');
            const dd = String(input.getDate()).padStart(2, '0');
            const mon = String(input.getMonth() + 1).padStart(2, '0');
            const yyyy = input.getFullYear();
            return `${hh}:${mm} ${dd}/${mon}/${yyyy}`;
        }
    }

    function updateTimeDifferences() {
        const elements = document.querySelectorAll('.time-diff');
        elements.forEach(el => {
            const timeStr = el.dataset.time;
            if (timeStr) {
                el.textContent = formatTimeDifference(timeStr);
            }
        });
    }

    // Cập nhật ngay khi load
    updateTimeDifferences();

    // Cập nhật mỗi 30 giây (tuỳ bạn chọn, 1 phút cũng được)
    setInterval(updateTimeDifferences, 30000);
</script>
