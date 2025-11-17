<script>
    document.addEventListener('DOMContentLoaded', () => {
        // ----- DOM refs -----
        const otpView = document.getElementById('sendOtp');
        const verifyView = document.getElementById('verify');
        const emailInput = document.querySelector('input[name="email"]');
        const phoneInput = document.querySelector('input[name="phone"]');
        const btnSubmitOtp = document.getElementById('submitOtp');
        const btnBack = document.getElementById('btn-back');
        const phoneLabel = document.getElementById('phone');
        const btnResendOtp = document.getElementById('resend-otp');

        let email = '';
        let phone = '';
        let isSubmitting = false;

        // ----- Helpers -----
        const getCsrf = () => {
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        };

        const isValidEmail = (str) => {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(str);
        };

        const verifyOtpView = () => {
            otpView.classList.add('d-none');
            verifyView.classList.remove('d-none');
            if (phoneLabel) phoneLabel.textContent = email;
        };

        const returnOtpView = () => {
            verifyView.classList.add('d-none');
            otpView.classList.remove('d-none');
            emailInput.value = '';
            email = '';
        };

        const setLoading = (loading, btnSubmit = btnSubmitOtp) => {
            isSubmitting = loading;
            btnSubmit.disabled = loading;
            btnSubmit.classList.toggle('disabled', loading);
            if (loading) {
                btnSubmit.dataset._text = btnSubmit.textContent;
                btnSubmit.textContent = 'Đang gửi...';
            } else {
                if (btnSubmit.dataset._text) {
                    btnSubmit.textContent = btnSubmit.dataset._text;
                    delete btnSubmit.dataset._text;
                }
            }
        };

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

        const toastError = (text) => {
            $.toast?.({
                heading: 'Lỗi',
                text,
                icon: 'error',
                position: 'top-right',
                hideAfter: 5000
            });
        };

        // ===== GỬI OTP: CHỈ CHUYỂN MÀN, KHÔNG GỌI API =====
        btnSubmitOtp.addEventListener('click', (e) => {
            e.preventDefault();
            if (isSubmitting) return;

            email = (emailInput.value || '').trim();
            if (!email) {
                toastError('Vui lòng nhập email.');
                emailInput.focus();
                return;
            }
            if (!isValidEmail(email)) {
                toastError('Email không hợp lệ.');
                emailInput.focus();
                return;
            }

            // Không gọi API nữa, chỉ chuyển sang màn hình nhập OTP
            verifyOtpView();
        });

        // Nút quay lại
        if (btnBack) {
            btnBack.addEventListener('click', (e) => {
                e.preventDefault();
                if (!verifyView.classList.contains('d-none')) {
                    returnOtpView();
                } else {
                    window.history.length > 1 ? window.history.back() : null;
                }
            });
        }

        // Resend OTP: vẫn đang gọi API, nếu anh muốn bỏ API luôn thì sửa tương tự
        btnResendOtp.addEventListener('click', async (e) => {
            e.preventDefault();
            if (isSubmitting) return;

            email = (emailInput.value || '').trim();
            if (!email) {
                toastError('Vui lòng nhập email.');
                emailInput.focus();
                return;
            }
            if (!isValidEmail(email)) {
                toastError('Email không hợp lệ.');
                emailInput.focus();
                return;
            }

            const csrf = getCsrf();
            if (!csrf) {
                console.warn('Missing <meta name="csrf-token"> in layout.');
            }

            const submitResendOtpForm = new FormData();
            submitResendOtpForm.append('_token', csrf);
            submitResendOtpForm.append('email', email);

            try {
                setLoading(true, btnResendOtp);

                const res = await fetch('{{ route('api.v1.user.sendOTP') }}', {
                    method: 'POST',
                    body: submitResendOtpForm,
                });

                let data;
                try {
                    data = await res.json();
                } catch (err) {
                    data = {
                        status: res.status,
                        message: 'Không đọc được phản hồi máy chủ.'
                    };
                }

                if (res.ok && (data.status === 200 || data.success === true)) {
                    toastSuccess(data.message || 'Đã gửi mã OTP.');
                } else {
                    if (data.errors) {
                        let allMessages = [];
                        Object.values(data.errors).forEach(errors => {
                            if (Array.isArray(errors)) {
                                allMessages = allMessages.concat(errors);
                            } else if (typeof errors === 'string') {
                                allMessages.push(errors);
                            }
                        });
                        toastError(allMessages.join('<br>'));
                    } else {
                        toastError(data.message || 'Gửi mã OTP thất bại.');
                    }
                }
            } catch (err) {
                console.error(err);
                toastError('Có lỗi kết nối. Vui lòng thử lại.');
            } finally {
                setLoading(false, btnResendOtp);
            }
        });
    });
</script>
