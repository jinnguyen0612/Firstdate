<script>
    const toastSuccess = (text) => {
        $.toast?.({
            heading: 'Thành công',
            text,
            icon: 'success',
            position: 'top-right',
            bgColor: '#28a745',
            textColor: '#fff',
            hideAfter: 3000
        });
    };

    document.addEventListener('DOMContentLoaded', () => {
        const appInfoView = document.getElementById('app-info');
        const userInfoView = document.getElementById('user-info');
        const backBtn = document.getElementById('btn-back-swiper-container');
        const body = document.body;

        // --- Toast: luôn cho phép hiển thị, không phụ thuộc user/token ---
        const toastMessage = localStorage.getItem('toast');
        if (toastMessage) {
            toastSuccess(toastMessage);
            localStorage.removeItem('toast');
        }

        // --- Đọc user & token an toàn ---
        let user = null;
        let token = null;

        try {
            const userRaw = localStorage.getItem('user');
            const tokenRaw = localStorage.getItem('token');

            user = userRaw ? JSON.parse(userRaw) : null;
            token = tokenRaw ? JSON.parse(tokenRaw) : null;
        } catch (e) {
            console.error('Lỗi parse localStorage:', e);
        }

        if (!appInfoView || !userInfoView) return;

        // --- Logic hiển thị view ---
        if (user && token) {
            console.log('user', user);
            console.log('token', token);

            if (user.status === 'active') {
                // Đã active: show app-info, ẩn user-info, clear localStorage
                appInfoView.classList.remove('d-none');
                localStorage.removeItem('user');
                localStorage.removeItem('token');
                body.style.backgroundColor = '#ffafaf71';
            } else if (user.status === 'draft') {
                // Chưa hoàn thành: show user-info, ẩn app-info
                userInfoView.classList.remove('d-none');
                backBtn.classList.remove('d-none');
                body.style.backgroundColor = '';

            } else {
                body.style.backgroundColor = '';
            }
        } else {
            // Không có user/token: tùy ý default
            // Ví dụ: show app-info, ẩn user-info
            appInfoView.classList.remove('d-none');
            userInfoView.classList.add('d-none');
            body.style.backgroundColor = '#ffafaf71';
        }
    });
</script>
