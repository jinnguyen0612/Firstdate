@extends('partner.layouts.guest')

@section('title', $title)

@push('libs-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('custom-css')
    @include('partner.checkin.styles.style')
@endpush


@section('content')
    <div class="container">
        <div class="card shadow-sm p-3">
            <div class="title">
                <div class="app-name"><span class="logo"></span> <span style="margin-top: 10px">FirstDate</span></div>
                <div class="table-name">Bàn #{{ $booking['table']['code'] }}</div>
                <div class="booking-name">Nhập mã PIN của Tài khoản để điểm danh cuộc hẹn #{{ $booking['code'] }}
                </div>
            </div>

            <div class="height-100 d-flex justify-content-center align-items-center border-none">
                <div class="position-relative">
                    <div class="text-center">
                        <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                            <input class="m-1 text-center form-control rounded" type="text" inputmode="numeric"
                                pattern="[0-9]*" id="first" maxlength="1" />
                            <input class="m-1 text-center form-control rounded" type="text" inputmode="numeric"
                                pattern="[0-9]*" id="second" maxlength="1" />
                            <input class="m-1 text-center form-control rounded" type="text" inputmode="numeric"
                                pattern="[0-9]*" id="third" maxlength="1" />
                            <input class="m-1 text-center form-control rounded" type="text" inputmode="numeric"
                                pattern="[0-9]*" id="fourth" maxlength="1" />
                            <input class="m-1 text-center form-control rounded" type="text" inputmode="numeric"
                                pattern="[0-9]*" id="fifth" maxlength="1" />
                            <input class="m-1 text-center form-control rounded" type="text" inputmode="numeric"
                                pattern="[0-9]*" id="sixth" maxlength="1" />
                            <input type="hidden" name="pin">
                        </div>
                        <button id="validateBtn" class="btn btn-default mt-4">Điểm danh</button>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                {{-- <button type="button" id="btn-checkin" class="btn btn-default py-2 px-4">Xác nhận</button> --}}
                <a href="#" class="app-icon">
                    <img width="40px" height="40px" src="{{ asset('public/assets/svg/google-play-svgrepo-com.svg') }}"
                        alt="CH Play">
                </a>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <a href="#" class="app-icon">
                    <img width="40px" height="40px" src="{{ asset('public/assets/svg/app-store-svgrepo-com.svg') }}"
                        alt="App Store">
                </a>
            </div>
        </div>
        <div class="modal-backdrop" id="modalBackdrop">
            <div class="modal-custom">
                <div class="glow-ring"></div>
                <h2 id="modalTitle">A</h2>
                <p id="modalMessage">B</p>
                <button class="close-btn">Xác nhận</button>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ====== DOM refs ======
            const otpInputs = document.querySelectorAll('#otp input[type="text"]');
            const hiddenInput = document.querySelector('#otp input[type="hidden"]');
            const validateBtn = document.getElementById('validateBtn');

            const closeBtn = document.querySelector('.close-btn');
            const backdrop = document.getElementById('modalBackdrop');
            const modalTitle = document.getElementById('modalTitle');
            const modalMessage = document.getElementById('modalMessage');

            // ====== Modal helpers ======
            const showModal = (title, message) => {
                modalTitle.textContent = title || '';
                modalMessage.textContent = message || '';
                backdrop.style.display = 'flex';
            };
            const hideModal = () => (backdrop.style.display = 'none');
            closeBtn.addEventListener('click', hideModal);
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') hideModal();
            });

            // ====== Hidden value ======
            const updateHiddenValue = () => {
                hiddenInput.value = Array.from(otpInputs).map(i => i.value).join('');
            };

            // ====== Focus helpers (luôn chọn FULL ô khi focus) ======
            const focusPrevOf = (i) => {
                if (i > 0) {
                    otpInputs[i - 1].focus();
                    // chọn toàn bộ nội dung ô trước
                    requestAnimationFrame(() => otpInputs[i - 1].select());
                }
            };
            const focusNextOf = (i) => {
                if (i < otpInputs.length - 1) {
                    otpInputs[i + 1].focus();
                    // đi tới ô sau cũng cho phép ghi đè nhanh -> select toàn bộ
                    requestAnimationFrame(() => otpInputs[i + 1].select());
                }
            };

            // ====== OTP handlers ======
            otpInputs.forEach((input, index) => {
                // Nhập số, auto-next, bắt xoá qua inputType (IME Android)
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

                // Backspace ổn định trên Android (keydown luôn bắn)
                input.addEventListener('keydown', (e) => {
                    const isBackspace = e.key === 'Backspace' || e.keyCode === 8 || e.which === 8;
                    if (!isBackspace) return;

                    if (!input.value) {
                        e.preventDefault(); // tránh giật
                        focusPrevOf(index); // khi lùi -> select full ô trước
                        updateHiddenValue();
                    }
                });

                // Fallback: vài bàn phím còn bắn keyup
                input.addEventListener('keyup', (e) => {
                    const isBackspace = e.key === 'Backspace' || e.keyCode === 8 || e.which === 8;
                    if (isBackspace && !input.value) {
                        focusPrevOf(index); // khi lùi -> select full ô trước
                        updateHiddenValue();
                    }
                });

                // Chạm vào để sửa -> luôn chọn FULL ô (không caret cuối)
                input.addEventListener('focus', (e) => {
                    requestAnimationFrame(() => e.target.select());
                });

                // Dán: phân bổ vào từng ô, cắt đúng độ dài
                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData)
                        .getData('text')
                        .replace(/\D/g, '')
                        .slice(0, otpInputs.length);

                    paste.split('').forEach((ch, i) => {
                        if (otpInputs[i]) otpInputs[i].value = ch;
                    });

                    updateHiddenValue();
                    const last = Math.min(paste.length, otpInputs.length) - 1;
                    if (last >= 0) {
                        otpInputs[last].focus();
                        // sau khi dán, chọn full ô hiện tại để người dùng ghi đè nhanh nếu cần
                        requestAnimationFrame(() => otpInputs[last].select());
                    }
                });

                // Ngăn IME bơm ký tự không phải số
                input.addEventListener('beforeinput', (e) => {
                    if (e.data && /\D/.test(e.data)) e.preventDefault();
                });
            });

            // Focus vào ô đầu tiên trống (và chọn full)
            const firstEmpty = Array.from(otpInputs).find(i => !i.value) || otpInputs[0];
            if (firstEmpty) {
                firstEmpty.focus();
                requestAnimationFrame(() => firstEmpty.select());
            }

            // ====== Submit ======
            validateBtn.addEventListener('click', async () => {
                const otp = hiddenInput.value;
                if (otp.length < otpInputs.length) {
                    showModal('Thiếu mã PIN', 'Vui lòng nhập đủ mã PIN.');
                    return;
                }

                // Khoá nút khi gửi
                const originalText = validateBtn.textContent;
                validateBtn.disabled = true;
                validateBtn.textContent = 'Đang xử lý...';

                try {
                    const res = await fetch(
                        '{{ route('partner.send-checkin', ['userCode' => $user['code'], 'bookingCode' => $booking['code']]) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="X-TOKEN"]')
                                    .content,
                            },
                            body: JSON.stringify({
                                pin: otp
                            })
                        }
                    );

                    const data = await res.json().catch(() => ({}));

                    if (data.status === 200) {
                        showModal('Thành công', data.message || 'Điểm danh thành công');
                        setTimeout(() => {
                            window.location.replace(
                                "{{ route('partner.checkin', ['code' => $booking['table']['code']]) }}"
                                );
                        }, 1000);
                    } else {
                        showModal('Thất bại', data.message ||
                            'Điểm danh thất bại, vui lòng thử lại');
                        setTimeout(hideModal, 5000);
                    }
                } catch (err) {
                    showModal('Lỗi kết nối',
                        'Không thể gửi yêu cầu. Vui lòng kiểm tra mạng và thử lại.');
                    setTimeout(hideModal, 5000);
                } finally {
                    validateBtn.disabled = false;
                    validateBtn.textContent = originalText;
                }
            });
        });
    </script>
@endpush
