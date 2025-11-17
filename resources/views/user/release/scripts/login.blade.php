<script>
    document.addEventListener('DOMContentLoaded', () => {
        // ----- DOM refs -----
        const otpView         = document.getElementById('sendOtp');
        const verifyView      = document.getElementById('verify');
        const usernameInput   = document.querySelector('input[name="username"]');
        const btnSubmitOtp    = document.getElementById('submitOtp');
        const btnBack         = document.getElementById('btn-back');
        const phoneLabel      = document.getElementById('phone');
        const btnResendOtp    = document.getElementById('resend-otp');
        const timerContainer  = document.getElementById('timer-container');
        const resendContainer = document.getElementById('resend-otp-container');
        const verifyDesc      = verifyView.querySelector('p');

        let username     = '';
        let isSubmitting = false;
        let loginType    = null; // 'email' | 'phone'

        // Cho script OTP biết mode hiện tại
        window.loginType = null;

        // ----- Helpers -----
        const getCsrf = () => {
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        };

        const isValidEmail = (str) => {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(str);
        };

        const isValidPhone = (str) => {
            const cleaned = str.replace(/\s+/g, '');
            return /^0\d{9}$/.test(cleaned) || /^\+84\d{9}$/.test(cleaned);
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

        const switchToVerifyView = (type) => {
            loginType       = type;
            window.loginType = type; // cho script OTP biết
            otpView.classList.add('d-none');
            verifyView.classList.remove('d-none');

            if (type === 'email') {
                // OTP 4 số
                verifyDesc.innerHTML =
                    'Một mã xác thực đã được gửi đến email <span id="phone"></span>, vui lòng kiểm tra tin nhắn của bạn';

                timerContainer.classList.remove('d-none');
                resendContainer.classList.remove('d-none');

                if (typeof window.setOtpLength === 'function') {
                    window.setOtpLength(4);
                }

                if (typeof timer === 'function') {
                    timer();
                }
            } else {
                // PIN 6 số
                verifyDesc.innerHTML =
                    'Vui lòng nhập mã PIN 6 số <span id="phone"></span>.';

                timerContainer.classList.add('d-none');
                resendContainer.classList.add('d-none');

                if (typeof window.setOtpLength === 'function') {
                    window.setOtpLength(6);
                }
            }

            const label = document.getElementById('phone');
            if (label) label.textContent = username;
        };

        const returnOtpView = () => {
            verifyView.classList.add('d-none');
            otpView.classList.remove('d-none');
            usernameInput.value = '';
            username   = '';
            loginType  = null;
            window.loginType = null;
        };

        // ----- Events -----
        btnSubmitOtp.addEventListener('click', async (e) => {
            e.preventDefault();
            if (isSubmitting) return;

            username = (usernameInput.value || '').trim();
            if (!username) {
                toastError('Vui lòng nhập email hoặc số điện thoại.');
                usernameInput.focus();
                return;
            }

            // Trường hợp EMAIL => gửi OTP, 4 số
            if (isValidEmail(username)) {
                const csrf = getCsrf();
                if (!csrf) {
                    console.warn('Missing <meta name="csrf-token"> in layout.');
                }

                const submitOtpForm = new FormData();
                submitOtpForm.append('_token', csrf);
                submitOtpForm.append('email', username); // backend vẫn nhận key "email"

                try {
                    setLoading(true);

                    const res = await fetch('{{ route('api.v1.user.sendOTP') }}', {
                        method: 'POST',
                        body: submitOtpForm,
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
                        switchToVerifyView('email');
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
                    setLoading(false);
                }
                return;
            }

            // Trường hợp PHONE => sang màn PIN, 6 số (không gửi OTP)
            if (isValidPhone(username)) {
                switchToVerifyView('phone');
                return;
            }

            toastError('Vui lòng nhập email hoặc số điện thoại hợp lệ.');
            usernameInput.focus();
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

        // Gửi lại OTP: chỉ cho email
        btnResendOtp.addEventListener('click', async (e) => {
            e.preventDefault();
            if (isSubmitting) return;
            if (loginType !== 'email') return;

            username = (usernameInput.value || '').trim();
            if (!username) {
                toastError('Vui lòng nhập email.');
                usernameInput.focus();
                return;
            }
            if (!isValidEmail(username)) {
                toastError('Email không hợp lệ.');
                usernameInput.focus();
                return;
            }

            const csrf = getCsrf();
            if (!csrf) {
                console.warn('Missing <meta name="csrf-token"> in layout.');
            }

            const submitResendOtpForm = new FormData();
            submitResendOtpForm.append('_token', csrf);
            submitResendOtpForm.append('email', username);

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
                    if (typeof timer === 'function') {
                        timer();
                    }
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
