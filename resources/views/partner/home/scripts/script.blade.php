<script>
    let bookingId = null;

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');

        const tabId = tab === 'confirm' ? 'confirm-tab' : 'new-tab';
        const tabTrigger = document.querySelector(`#${tabId}`);
        const tabInstance = new bootstrap.Tab(tabTrigger);
        tabInstance.show();
    });

    $(document).ready(function() {
        // Trigger submit khi search hoặc date thay đổi
        $('#filterForm').on('change', 'input[name="date"]', function() {
            submitForm($.Event('submit'), $('#filterForm'));
        });

        let debounceTimer;
        $('#filterForm').on('keyup', 'input[name="search"]', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                submitForm($.Event('submit'), $('#filterForm'));
            }, 300); // debounce tránh gọi liên tục
        });

        // Người dùng submit bằng Enter hoặc nút tìm kiếm
        $('#filterForm').on('submit', function(e) {
            submitForm(e, $(this));
        });

        function getAjaxOptions(activeTabPaneId) {
            if (activeTabPaneId === 'new') {
                return {
                    url: '{{ route('partner.booking.filterNew') }}',
                    targetDiv: '#tab-new-deal'
                };
            } else {
                return {
                    url: '{{ route('partner.booking.filterConfirm') }}',
                    targetDiv: '#tab-list-booking'
                };
            }
        }

        function submitForm(e, $form) {
            e.preventDefault();

            const activeTabPaneId = $('.tab-pane.active').attr('id'); // 'home' hoặc 'profile'
            const {
                url,
                targetDiv
            } = getAjaxOptions(activeTabPaneId);
            const formData = $form.serialize();

            $.ajax({
                url: url,
                method: 'GET',
                data: formData,
                beforeSend: function() {
                    $(targetDiv).html(`
                        <div class="text-center d-flex align-items-center justify-content-center" style="height: 400px">
                            <div class="spinner-border text-blue me-2" role="status"></div>
                            <h5>Loading<span class="animated-dots"></span></h5>
                        </div>
                    `);
                },
                success: function(response) {
                    $(targetDiv).html(response);
                    blind();
                },
                error: function() {
                    $(targetDiv).html(
                        '<div class="text-danger text-center">Có lỗi xảy ra. Vui lòng thử lại.</div>'
                    );
                }
            });
        }

        $('.badge-container').on('click', '.badge-button', function() {
            $('.badge-button').removeClass('active');
            $(this).addClass('active');

            const selectedStatus = $(this).data('status');

            // Nếu bạn muốn lọc lại kết quả sau khi chọn status
            $('input[name="status"]').remove(); // Xóa input status cũ nếu có
            $('#filterForm').append(
                `<input type="hidden" name="status" value="${selectedStatus}">`);
            $('#filterForm').submit();
        });

    });

    blind();

    function blind() {
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-reject, .btn-accept, .btn-to-processing');
            const card = e.target.closest('.card-deal');

            if (btn) {
                e.stopPropagation();
                let bookingId = btn.dataset.id;

                if (btn.classList.contains('btn-reject')) {
                    document.querySelector('#rejectModal input[name="id"]').value = bookingId;
                    new bootstrap.Modal(document.getElementById('rejectModal')).show();
                } else if (btn.classList.contains('btn-accept')) {
                    console.log('Chấp nhận booking', bookingId);
                } else if (btn.classList.contains('btn-to-processing')) {
                    console.log('Chuyển sang trạng thái đang diễn ra', bookingId);
                    e.preventDefault();
                    toProcessing(bookingId);
                }
            } else if (card) {
                window.location.href = card.dataset.url;
            }
        });
    }

</script>
