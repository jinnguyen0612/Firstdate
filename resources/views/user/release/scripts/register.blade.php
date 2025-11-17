<script>
    document.addEventListener('DOMContentLoaded', function() {
        const minAge = document.getElementById('minAge');
        const maxAge = document.getElementById('maxAge');

        const inputName = document.querySelector('input[name="fullname"]');
        const inputsGender = document.querySelectorAll('input[name="gender"]');
        const inputBirthday = document.querySelector('input[name="birthday"]');
        const inputAvatar = document.querySelector('input[name="avatar"]');
        const inputThumbnails = document.querySelector('input[name="thumbnails"]');
        const inputMinAgeFind = document.querySelector('input[name="min_age_find"]');
        const inputMaxAgeFind = document.querySelector('input[name="max_age_find"]');
        const inputAnswer = document.querySelector('input[name="answer"]'); // JSON chuỗi
        const inputLookingFor = document.querySelector('input[name="looking_for"]'); // single (CSV/chuỗi)
        const inputRelationship = document.querySelector('input[name="relationship"]'); // CSV
        const inputDatingTime = document.querySelector('input[name="dating_time"]'); // CSV

        // ====== Helpers ======
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

        // ==== state cục bộ (phục vụ log) ====
        let nameValue = '';
        let birthdayValue = '';
        let avatarValue = null;
        let thumbnailsValue = [];
        let answerValue = [];
        let lookingForValue = '';
        let relationshipValue = [];
        let datingTimeValue = [];
        let minAgeValue = '';
        let maxAgeValue = '';
        let genderValue = '';

        const parseCSV = (v) => {
            if (Array.isArray(v)) return v.map(x => String(x).trim()).filter(Boolean);
            if (typeof v === 'string') {
                const s = v.trim();
                if (!s) return [];
                return s.split(',').map(x => x.trim()).filter(Boolean);
            }
            return [];
        };
        const clamp18to99 = (raw) => {
            const n = parseInt(String(raw).replace(/\D/g, ''), 10);
            if (isNaN(n)) return '';
            return Math.max(18, Math.min(99, n));
        };
        const normalizeIds = (v) => {
            if (Array.isArray(v)) return v.map(Number).filter(Number.isFinite).map(n => Math.trunc(n))
                .filter(n => n > 0);
            if (typeof v === 'string') {
                const s = v.trim();
                if (!s) return [];
                try {
                    return normalizeIds(JSON.parse(s));
                } catch {
                    return s.split(/[,\s]+/).map(Number).filter(Number.isFinite).map(n => Math.trunc(n))
                        .filter(n => n > 0);
                }
            }
            return [];
        };

        function readGender() {
            const checked = Array.from(inputsGender).find(el => el.checked);
            genderValue = checked ? String(checked.value) : '';
            return genderValue;
        }

        function bindText(el, setter, useChange = false) {
            if (!el) return;
            setter(el.value || '');
            el.addEventListener(useChange ? 'change' : 'input', e => setter(e.target.value));
        }

        function bindSingleFile(el, setter) {
            if (!el) return;
            setter(null);
            el.addEventListener('change', () => setter(el.files && el.files[0] ? el.files[0] : null));
        }

        function bindMultiFiles(el, setter) {
            if (!el) return;
            const sync = () => setter(Array.from(el.files || []));
            setter([]);
            el.addEventListener('change', sync);
            el.addEventListener('filesynced', sync);
        }

        function bindCSVHidden(el, setter) {
            if (!el) return;
            setter(parseCSV(el.value));
            el.addEventListener('change', () => setter(parseCSV(el.value)));
            el.addEventListener('valuesynced', () => setter(parseCSV(el.value)));
        }
        bindText(inputName, v => {
            nameValue = v;
        });
        bindText(inputBirthday, v => {
            birthdayValue = v;
        }, true);
        bindSingleFile(inputAvatar, f => {
            avatarValue = f;
        });
        bindMultiFiles(inputThumbnails, fs => {
            thumbnailsValue = fs;
        });
        bindCSVHidden(inputRelationship, v => {
            relationshipValue = v;
        });
        bindCSVHidden(inputDatingTime, v => {
            datingTimeValue = v;
        });
        // lookingFor là single; nếu bạn render CSV thì vẫn lấy phần tử đầu.
        if (inputLookingFor) {
            const init = parseCSV(inputLookingFor.value);
            lookingForValue = init.length ? init[0] : (inputLookingFor.value || '');
            inputLookingFor.addEventListener('change', () => {
                const vals = parseCSV(inputLookingFor.value);
                lookingForValue = vals.length ? vals[0] : (inputLookingFor.value || '');
            });
        }

        // Age sync
        const syncMin = () => {
            const v = clamp18to99(inputMinAgeFind.value);
            inputMinAgeFind.value = v === '' ? '' : String(v);
            minAgeValue = inputMinAgeFind.value;
            if (inputMinAgeFind.value !== '' && inputMaxAgeFind.value !== '' &&
                Number(inputMinAgeFind.value) > Number(inputMaxAgeFind.value)) {
                inputMaxAgeFind.value = inputMinAgeFind.value;
                syncMax();
            }
        };
        const syncMax = () => {
            const v = clamp18to99(inputMaxAgeFind.value);
            inputMaxAgeFind.value = v === '' ? '' : String(v);
            maxAgeValue = inputMaxAgeFind.value;
            if (inputMinAgeFind.value !== '' && inputMaxAgeFind.value !== '' &&
                Number(inputMaxAgeFind.value) < Number(inputMinAgeFind.value)) {
                inputMaxAgeFind.value = inputMinAgeFind.value;
                maxAgeValue = inputMaxAgeFind.value;
            }
        };
        inputMinAgeFind?.addEventListener('blur', () => {
            if (inputMinAgeFind.value !== '' && Number(inputMinAgeFind.value) < 18) inputMinAgeFind
                .value = '18';
            syncMin();
        });
        inputMaxAgeFind?.addEventListener('blur', () => {
            if (inputMaxAgeFind.value !== '' && Number(inputMaxAgeFind.value) < 18) inputMaxAgeFind
                .value = '18';
            syncMax();
        });

        // gender
        if (inputsGender.length) {
            readGender();
            inputsGender.forEach(el => el.addEventListener('change', readGender));
        }

        // answer (JSON hidden)
        if (inputAnswer) {
            const ids = normalizeIds(inputAnswer.value ?? []);
            answerValue = ids;
            inputAnswer.addEventListener('input', () => {
                answerValue = normalizeIds(inputAnswer.value);
            });
            inputAnswer.addEventListener('change', () => {
                answerValue = normalizeIds(inputAnswer.value);
            });
        }

        // ===== collect & submit all values as FormData (kèm file) =====
        function collectFormData(subsidy) {
            const fd = new FormData();

            // Đọc TRỰC TIẾP từ DOM để chắc chắn là mới nhất:
            const fullname = inputName?.value?.trim() || '';
            const birthday = inputBirthday?.value || '';
            const gender = readGender() || '';
            const minAgeFind = inputMinAgeFind?.value || '';
            const maxAgeFind = inputMaxAgeFind?.value || '';
            const lookingFor = (() => {
                const csv = parseCSV(inputLookingFor?.value ?? '');
                return csv.length ? csv[0] : (inputLookingFor?.value ?? '');
            })();
            const relationship = parseCSV(inputRelationship?.value ?? ''); // array
            const datingTime = parseCSV(inputDatingTime?.value ?? ''); // array
            const answers = normalizeIds(inputAnswer?.value ?? answerValue ?? []);

            // Các field đơn
            fd.append('fullname', fullname);
            fd.append('birthday', birthday);
            fd.append('gender', gender);
            fd.append('lng', 106.648151);
            fd.append('lat', 10.840800);
            if (minAgeFind !== '') fd.append('min_age_find', minAgeFind);
            if (maxAgeFind !== '') fd.append('max_age_find', maxAgeFind);
            if (lookingFor !== '') fd.append('looking_for', lookingFor);

            // Các field mảng: Laravel nhận cả "relationship[]" & "dating_time[]"
            relationship.forEach(v => fd.append('relationship[]', v));
            datingTime.forEach(v => fd.append('dating_time[]', v));
            answers.forEach(id => fd.append('answer[]', String(id)));

            // file
            if (inputAvatar?.files?.[0]) {
                fd.append('avatar', inputAvatar.files[0]);
            }
            if (inputThumbnails?.files?.length) {
                Array.from(inputThumbnails.files).forEach((f, i) => {
                    fd.append('thumbnails[]', f);
                });
            }

            // subsidy từ nút bấm
            fd.append('is_subsidy_offer', String(subsidy ?? 0));

            return fd;
        }

        // Submit: bắt cả hai nút .btnSubmitRegister
        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('.btnSubmitRegister');
            const appInfoView = document.getElementById('app-info');
            const userInfoView = document.getElementById('user-info');
            const backBtn = document.getElementById('btn-back-swiper-container');
            const body = document.body;

            if (!btn) return;

            const subsidy = Number(btn.dataset.subsidy || '0');

            if (btn.disabled) return;
            btn.disabled = true;

            try {
                const fd = collectFormData(subsidy);
                // for (const [k, v] of fd.entries()) {
                //     if (v instanceof File) {
                //         console.log(k, {
                //             name: v.name,
                //             size: v.size,
                //             type: v.type
                //         });
                //     } else {
                //         console.log(k, v);
                //     }
                // }


                // debug: in thử key/value (chú ý file sẽ hiện [object File])
                // for (const [k, v] of fd.entries()) console.log(k, v);

                // Lấy token từ localStorage (tùy anh đang lưu kiểu gì)
                let bearerToken = null;
                const raw = localStorage.getItem('token');
                if (raw) {
                    // Nếu anh lưu dạng JSON: { access_token: 'xxx', ... }
                    const parsed = JSON.parse(raw);
                    bearerToken = parsed.access_token || parsed.token || raw;
                }

                const res = await fetch("{{ route('api.v1.user.registerInfo') }}", {
                    method: 'POST',
                    // KHÔNG set 'Content-Type' cho FormData — trình duyệt tự thêm boundary
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            ?.content || '',
                        ...(bearerToken ? {
                            'Authorization': `Bearer ${bearerToken}`
                        } : {})
                    },
                    body: fd,
                    credentials: 'same-origin'
                });

                const data = await res.json().catch(() => ({}));
                if (data.status === 200) {
                    toastSuccess('Cập nhật thông tin thành công!');
                    appInfoView.classList.remove('d-none');
                    userInfoView.classList.add('d-none');
                    backBtn.classList.add('d-none');
                    body.style.backgroundColor = '#ffafaf71';
                    localStorage.removeItem('user');
                    localStorage.removeItem('token');
                    return;
                } else {
                    if (data.message_validate) {
                        let allMessages = [];
                        Object.values(data.message_validate).forEach(errors => {
                            if (Array.isArray(errors)) {
                                allMessages = allMessages.concat(errors);
                            } else if (typeof errors === 'string') {
                                allMessages.push(errors);
                            }
                        });
                        toastError(allMessages.join('<br>'));
                    } else {
                        toastError(data.message ||
                            'Đã có lỗi xảy ra, vui lòng kiểm tra lại!');
                    }
                }
            } catch (err) {
                console.error('Network error:', err);
                toastError('Có lỗi kết nối. Vui lòng thử lại.');
            } finally {
                btn.disabled = false;
            }
        });
    });
</script>
