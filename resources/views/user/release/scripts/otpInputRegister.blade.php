<script>
    document.addEventListener("DOMContentLoaded", function() {
        const otpInputs   = Array.from(document.querySelectorAll('#otp input[type="text"]'));
        const hiddenInput = document.querySelector('#otp input[type="hidden"][name="pin"]');
        const validateBtn = document.getElementById('validateBtn');
        const emailInput  = document.querySelector('input[name="email"]');
        const phoneInput  = document.querySelector('input[name="phone"]');

        // mặc định: PIN 6 số
        let ACTIVE_LEN = 6;

        const getActiveInputs = () =>
            otpInputs.filter((inp, idx) => idx < ACTIVE_LEN && !inp.classList.contains('d-none'));

        const getOtp = () => getActiveInputs().map(i => i.value).join('');
        const allFilled = () =>
            getActiveInputs().every(i => i.value && i.value.length === 1);

        const setInputsDisabled = (disabled) => getActiveInputs().forEach(i => i.disabled = disabled);

        const clearOtp = () => {
            getActiveInputs().forEach(i => i.value = '');
            hiddenInput.value = '';
            const first = getActiveInputs()[0];
            if (first) {
                first.focus();
                requestAnimationFrame(() => first.select());
            }
        };

        const focusPrevOf = (index) => {
            for (let i = index - 1; i >= 0; i--) {
                if (i < ACTIVE_LEN) {
                    otpInputs[i].focus();
                    requestAnimationFrame(() => otpInputs[i].select());
                    break;
                }
            }
        };

        const focusNextOf = (index) => {
            for (let i = index + 1; i < ACTIVE_LEN; i++) {
                otpInputs[i].focus();
                requestAnimationFrame(() => otpInputs[i].select());
                break;
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

        const buildPayload = (otpValue) => {
            const email = emailInput?.value?.trim() || null;
            const phone = phoneInput?.value?.trim() || null;
            return {
                email: email,
                phone: phone,
                pin: otpValue
            };
        };

        let isVerifying       = false;
        let currentController = null;

        async function verifyOtp(jsonPayload) {
            if (isVerifying) {
                try { currentController?.abort(); } catch {}
            }

            isVerifying       = true;
            currentController = new AbortController();
            setInputsDisabled(true);

            const url = "{{ route('api.v1.user.register') }}";

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify(jsonPayload),
                    signal: currentController.signal,
                    credentials: 'same-origin'
                });

                const data = await res.json().catch(() => ({}));

                if (data.user && data.token) {
                    localStorage.setItem('toast', 'Đăng nhập thành công');
                    localStorage.setItem('user', JSON.stringify(data.user));
                    localStorage.setItem('token', JSON.stringify(data.token)); // token thường là string
                    window.location.href = "{{ route('user.app') }}";
                    return;
                }

                if (data.status === 400 && data.message_validate) {
                    const messages = [];
                    Object.values(data.message_validate).forEach(errs => {
                        if (Array.isArray(errs)) messages.push(...errs);
                        else if (typeof errs === 'string') messages.push(errs);
                    });
                    toastError(messages.join('<br>'));
                    windown.location.reload();
                } else {
                    const msg = data.message;
                    toastError(msg);
                    windown.location.reload();
                }

                clearOtp();
            } catch (err) {
                if (err.name !== 'AbortError') {
                    toastError('Không thể kết nối máy chủ. Vui lòng thử lại.');
                    clearOtp();
                }
            } finally {
                isVerifying = false;
                setInputsDisabled(false);
            }
        }

        // chỉ sync hidden, KHÔNG auto gọi API
        const updateHiddenValue = () => {
            hiddenInput.value = getOtp();
        };

        // ====== OTP / PIN handlers ======
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.inputType === 'deleteContentBackward') {
                    if (!input.value) focusPrevOf(index);
                    updateHiddenValue();
                    return;
                }
                let v = e.target.value.replace(/\D/g, '');
                if (v.length > 1) v = v.charAt(0);
                e.target.value = v;

                if (v) focusNextOf(index);
                updateHiddenValue();
            });

            input.addEventListener('keydown', (e) => {
                const isBackspace = e.key === 'Backspace' || e.keyCode === 8 || e.which === 8;
                if (isBackspace && !input.value) {
                    e.preventDefault();
                    focusPrevOf(index);
                    updateHiddenValue();
                }

                const isEnter = e.key === 'Enter' || e.keyCode === 13;
                if (isEnter && index < ACTIVE_LEN && allFilled()) {
                    // Enter mới gọi API
                    verifyOtp(buildPayload(getOtp()));
                }
            });

            input.addEventListener('keyup', (e) => {
                const isBackspace = e.key === 'Backspace' || e.keyCode === 8 || e.which === 8;
                if (isBackspace && !input.value) {
                    focusPrevOf(index);
                    updateHiddenValue();
                }
            });

            input.addEventListener('focus', (e) => {
                requestAnimationFrame(() => e.target.select());
            });

            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData)
                    .getData('text')
                    .replace(/\D/g, '')
                    .slice(0, ACTIVE_LEN);

                const active = getActiveInputs();
                paste.split('').forEach((ch, i) => {
                    if (active[i]) active[i].value = ch;
                });

                hiddenInput.value = getOtp();

                const lastIndex = Math.min(paste.length, ACTIVE_LEN) - 1;
                if (lastIndex >= 0 && active[lastIndex]) {
                    active[lastIndex].focus();
                    requestAnimationFrame(() => active[lastIndex].select());
                }

                updateHiddenValue();
            });

            input.addEventListener('beforeinput', (e) => {
                if (e.data && /\D/.test(e.data)) e.preventDefault();
            });
        });

        // Focus vào ô đầu tiên
        const first = getActiveInputs()[0];
        if (first) {
            first.focus();
            requestAnimationFrame(() => first.select());
        }

        if (validateBtn) {
            validateBtn.addEventListener('click', (e) => {
                e.preventDefault();
                if (!allFilled()) {
                    toastError('Vui lòng nhập đầy đủ mã.');
                    return;
                }
                verifyOtp(buildPayload(getOtp()));
            });
        }
    });
</script>