<script>
    document.addEventListener('DOMContentLoaded', function() {
        const groupCheckbox = document.querySelector('.mail-group-checkbox');
        const checkboxes = document.querySelectorAll('.mail-checkbox');
        const btnRead = document.getElementById('btn-read');
        const btnDelete = document.getElementById('btn-delete');
        const mailBox = document.getElementById('tab-inbox-content');

        let currentPage = {{ $notifications->currentPage() }};

        // Check all
        groupCheckbox.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = groupCheckbox.checked);
        });

        // Lấy danh sách id được chọn
        function getSelectedIds() {
            return Array.from(checkboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);
        }

        // Gọi API multiple action
        function callMultipleAction(action) {
            let ids = getSelectedIds();
            ids = ids.filter(item => item !== 'on');
            console.log(ids);

            if (ids.length === 0) {
                alert('Vui lòng chọn ít nhất 1 thông báo.');
                return;
            }

            fetch(`{{ route('partner.notification.multipleAction') }}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="X-TOKEN"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        action: action,
                        ids: ids.join(',')
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Không thể kết nối server.');
                });
        }

        // Gán sự kiện nút
        btnRead.addEventListener('click', () => callMultipleAction('read'));
        btnDelete.addEventListener('click', () => callMultipleAction('delete'));

        // ===== Load page qua AJAX =====
        function loadPage(page) {
            fetch(`{{ route('partner.notification.loadPage') }}?page=${page}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.html) {
                        mailBox.innerHTML = data.html;
                        currentPage = data.currentPage || page;
                        bindPaginationEvents(); // bind lại sự kiện cho nút mới
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Không thể tải dữ liệu.');
                });
        }

        function bindPaginationEvents() {
            const btnPrevious = document.getElementById('btn-previous');
            const btnNext = document.getElementById('btn-next');
            updateTimeDifferences();

            if (btnPrevious) {
                btnPrevious.addEventListener('click', () => {
                    if (currentPage > 1) {
                        loadPage(currentPage - 1);
                    }
                });
            }

            if (btnNext) {
                btnNext.addEventListener('click', () => {
                    loadPage(currentPage + 1);
                });
            }
        }

        // Khởi tạo lần đầu
        bindPaginationEvents();
    });
</script>
