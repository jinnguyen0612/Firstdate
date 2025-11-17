<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inboxBtn = document.getElementById('tab-inbox-btn');
        const sentBtn = document.getElementById('tab-sent-btn');
        const inboxContent = document.getElementById('tab-inbox-content');
        const sentContent = document.getElementById('tab-sent-content');

        document.getElementById('btn-read-all').addEventListener('click', function() {
            $.ajax({
                url: "{{ route('partner.notification.readAll') }}",
                type: 'POST',
                data: {
                    _token: $('meta[name="X-TOKEN"]').attr('content')
                },
                success: function(res) {
                    if (res.status === 'success') {
                        $('#notificationBadge').text('');
                        $('#notificationListContainer').html(res.html);

                        // Hiển thị toast Bootstrap
                        $.toast({
                            heading: 'Thành công',
                            text: 'Đã đọc tất cả thông báo',
                            icon: 'success', // vẫn giữ icon
                            position: 'top-right',
                            bgColor: '#28a745', // xanh lá
                            textColor: '#fff',
                            hideAfter: 3000
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error: ', xhr);
                    $.toast({
                        heading: 'Thất bại',
                        text: 'Đã có lỗi xảy ra',
                        icon: 'error', // sẽ ra màu đỏ
                        position: 'top-right',
                        hideAfter: 10000
                    });
                }
            });
        });

        document.getElementById('btn-accept-delete').addEventListener('click', function() {
            $.ajax({
                url: "{{ route('partner.notification.deleteRead') }}",
                type: 'POST',
                data: {
                    _token: $('meta[name="X-TOKEN"]').attr('content')
                },
                success: function(res) {
                    if (res.status === 'success') {
                        // Load lại phần thông báo từ HTML trả về
                        $('#notificationListContainer').html(res.html);

                        // Đóng modal
                        $('#confirmModal').modal('hide');

                        // Toast
                        $.toast({
                            heading: 'Thành công',
                            text: res.message || 'Đã xóa các thông báo đã đọc',
                            icon: 'success',
                            position: 'top-right',
                            bgColor: '#28a745',
                            textColor: '#fff',
                            hideAfter: 3000
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error: ', xhr);
                    $.toast({
                        heading: 'Thất bại',
                        text: 'Đã có lỗi xảy ra',
                        icon: 'error',
                        position: 'top-right',
                        hideAfter: 10000
                    });
                }
            });
        });


        inboxBtn.addEventListener('click', function() {
            inboxBtn.classList.add('active');
            sentBtn.classList.remove('active');
            inboxContent.style.display = 'block';
            sentContent.style.display = 'none';
        });

        sentBtn.addEventListener('click', function() {
            sentBtn.classList.add('active');
            inboxBtn.classList.remove('active');
            inboxContent.style.display = 'none';
            sentContent.style.display = 'block';
        });
    });


    document.addEventListener('DOMContentLoaded', () => {
        const mailBox = document.getElementById('notificationListContainer');
        const loadingSpinner = document.getElementById('loading-spinner');
        const endMessage = document.getElementById('end-message');

        let currentPage = {{ $notifications->currentPage() }};
        let lastPage = {{ $notifications->lastPage() }};
        let isLoading = false;

        function loadMore(page) {
            if (isLoading) return;
            if (page > lastPage) return showEndMessage();

            isLoading = true;
            loadingSpinner.style.display = 'block';

            fetch(`{{ route('partner.notification.loadMore') }}?page=${page}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' && data.html) {
                        mailBox.insertAdjacentHTML('beforeend', data.html);
                        currentPage = data.current_page;
                        lastPage = data.last_page;
                    } else {
                        showEndMessage();
                    }
                })
                .catch(err => {
                    console.error(err);
                })
                .finally(() => {
                    isLoading = false;
                    loadingSpinner.style.display = 'none';
                });
        }

        function showEndMessage() {
            endMessage.style.display = 'block';
        }

        function onScroll() {
            const scrollPosition = window.innerHeight + window.scrollY;
            const threshold = document.body.offsetHeight - 100;

            if (scrollPosition >= threshold) {
                loadMore(currentPage + 1);
            }
        }

        window.addEventListener('scroll', onScroll);
    });
</script>
