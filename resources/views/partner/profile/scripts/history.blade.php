<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnPrevious = document.getElementById('btn-previous');
        const btnNext = document.getElementById('btn-next');
        let currentPage = {{ $transactions->currentPage() }};
        const tableContainer = document.querySelector('.table-container');

        function loadPage(page) {
            fetch(`{{ route('partner.profile.transaction.loadPage') }}?page=${page}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.html) {
                        tableContainer.innerHTML = data.html;
                        currentPage = data.currentPage || page;
                        bindPaginationEvents(); // bind lại sự kiện cho nút mới
                    }
                })
                .catch(err => {
                    console.error(err);
                });
        }

        function bindPaginationEvents() {
            const btnPrev = document.getElementById('btn-previous');
            const btnNxt = document.getElementById('btn-next');

            if (btnPrev) {
                btnPrev.addEventListener('click', () => {
                    if (currentPage > 1) {
                        loadPage(currentPage - 1);
                    }
                });
            }

            if (btnNxt) {
                btnNxt.addEventListener('click', () => {
                    loadPage(currentPage + 1);
                });
            }
        }

        // Khởi tạo lần đầu
        bindPaginationEvents();
    });

    document.addEventListener('DOMContentLoaded', () => {
        const mailBox = document.getElementById('mobile-history-container');
        const loadingSpinner = document.getElementById('loading-spinner');
        const endMessage = document.getElementById('end-message');

        let currentPage = {{ $transactions->currentPage() }};
        let hasMore = {{ $transactions->hasMorePages() }};
        let isLoading = false;

        function loadMore(page) {
            if (isLoading) return;
            if (!hasMore) return showEndMessage();

            isLoading = true;
            loadingSpinner.style.display = 'block';

            fetch(`{{ route('partner.profile.transaction.loadMore') }}?page=${page}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' && data.html) {
                        mailBox.insertAdjacentHTML('beforeend', data.html);
                        currentPage = data.current_page;
                        hasMore = data.has_more;
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
