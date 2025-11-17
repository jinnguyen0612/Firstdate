<script>
    document.addEventListener('DOMContentLoaded', () => {
        /* =======================
         *  DATA từ PHP (Blade)
         * ======================= */
        const REQUIRED = @json($requiredQuestion ?? [], JSON_UNESCAPED_UNICODE); // chỉ dùng cho slot 1,2
        const ALL = @json($allQuestion ?? [], JSON_UNESCAPED_UNICODE); // dùng cho slot >=3

        /* =======================
         *  REFS
         * ======================= */
        const grid = document.getElementById('qaGrid');
        const addBtn = document.getElementById('btnQaAdd');
        const hiddenAnswer = document.querySelector('input[name="answer"]');

        // Bottom sheets
        const backdrop = document.getElementById('qaBackdrop');
        const sheetQ = document.getElementById('qaSheetQuestion');
        const sheetA = document.getElementById('qaSheetAnswer');
        const qList = document.getElementById('qaQuestionList');
        const aList = document.getElementById('qaAnswerList');
        const aHeader = document.getElementById('qaAnswerHeader');

        /* =======================
         *  STATE
         * ======================= */
        let currentSlot = null; // slot đang thao tác
        const dataBySlot = new Map(); // "slot" -> {question_id, question_title, answer_id, answer_text}
        const selectedQIds = new Set(); // các question_id đã chọn (chống trùng)

        /* =======================
         *  SHEET HELPERS
         * ======================= */
        const openSheet = (el) => {
            backdrop.classList.add('open');
            el.classList.add('open');
            document.body.style.overflow = 'hidden';
        };
        const closeAll = () => {
            backdrop.classList.remove('open');
            sheetQ.classList.remove('open');
            sheetA.classList.remove('open');
            document.body.style.overflow = '';
        };

        backdrop.addEventListener('click', closeAll);
        document.addEventListener('click', e => {
            if (e.target.matches('.fd-close,[data-close]')) closeAll();
        });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeAll();
        });

        // Vuốt xuống để đóng (đơn giản)
        [sheetQ, sheetA].forEach(s => {
            let startY = null;
            s.addEventListener('touchstart', e => {
                startY = e.touches[0].clientY;
            }, {
                passive: true
            });
            s.addEventListener('touchmove', e => {
                if (startY == null) return;
                const dy = e.touches[0].clientY - startY;
                if (dy > 90) {
                    startY = null;
                    closeAll();
                }
            }, {
                passive: true
            });
            s.addEventListener('touchend', () => {
                startY = null;
            });
        });

        /* =======================
         *  DATA BUILDERS
         * ======================= */
        function poolForSlot(slot) {
            return (slot === 1 || slot === 2) ? REQUIRED : ALL;
        }

        function buildQuestionListForSlot(slot) {
            const pool = poolForSlot(slot);
            const current = dataBySlot.get(String(slot));
            const currentQid = current ? current.question_id : null;

            // Giữ câu hỏi hiện tại của slot (nếu có) để có thể đổi đáp án.
            // Lọc bỏ câu hỏi đã dùng ở slot khác (selectedQIds).
            return pool.filter(q => (q.id === currentQid) || !selectedQIds.has(q.id));
        }

        /* =======================
         *  RENDERERS (Sheet)
         * ======================= */
        function renderQuestionsForSlot(slot) {
            const list = buildQuestionListForSlot(slot);
            qList.innerHTML = '';

            if (!list.length) {
                const li = document.createElement('li');
                li.innerHTML = `<button type="button" disabled>Không còn câu hỏi phù hợp</button>`;
                qList.appendChild(li);
                return;
            }

            list.forEach(q => {
                const li = document.createElement('li');
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = q.content || q.title || '';
                btn.addEventListener('click', () => {
                    aHeader.textContent = q.content || q.title || 'Chọn câu trả lời';
                    renderAnswers(q);
                    sheetQ.classList.remove('open');
                    sheetA.classList.add('open');
                });
                li.appendChild(btn);
                qList.appendChild(li);
            });
        }

        function renderAnswers(q) {
            aList.innerHTML = '';
            (q.answers || []).forEach(ans => {
                const li = document.createElement('li');
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = ans.answer || ans.text || '';
                btn.addEventListener('click', () => applySelection(currentSlot, q, ans));
                li.appendChild(btn);
                aList.appendChild(li);
            });
        }

        /* =======================
         *  APPLY SELECTION
         * ======================= */
        function applySelection(slot, q, ans) {
            const key = String(slot);
            const prev = dataBySlot.get(key);

            // Gỡ question cũ khỏi tập selected (nếu đổi câu hỏi)
            if (prev && prev.question_id !== q.id) selectedQIds.delete(prev.question_id);

            dataBySlot.set(key, {
                question_id: q.id,
                question_title: q.content || q.title || '',
                answer_id: ans.id,
                answer_text: ans.answer || ans.text || ''
            });
            selectedQIds.add(q.id);

            paintCard(slot);
            syncHidden();
            closeAll();
        }

        /* =======================
         *  CARD UI
         * ======================= */
        function paintCard(slot) {
            const card = grid.querySelector(`.qa-card[data-slot="${slot}"]`);
            const data = dataBySlot.get(String(slot));
            if (!card) return;

            if (!data) {
                // reset về trạng thái rỗng
                card.classList.remove('filled');
                card.querySelector('.qa-card-main').innerHTML = `<span class="plus">+</span>`;
                const rmv = card.querySelector('.remove');
                if (rmv) rmv.remove();
                return;
            }

            card.classList.add('filled');
            card.querySelector('.qa-card-main').innerHTML = `
      <div>
        <div class="title">${data.question_title}</div>
        <div class="sub">${data.answer_text}</div>
      </div>
    `;
            ensureRemoveBtn(card);
        }

        function ensureRemoveBtn(card) {
            if (card.querySelector('.remove')) return;
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'remove';
            btn.textContent = '×';
            btn.addEventListener('click', (ev) => {
                ev.stopPropagation();
                const slot = Number(card.dataset.slot);
                const key = String(slot);
                const prev = dataBySlot.get(key);
                if (prev) {
                    selectedQIds.delete(prev.question_id);
                    dataBySlot.delete(key);
                }
                // Không dồn/reindex: chỉ reset card này
                paintCard(slot);
                syncHidden();
            });
            card.appendChild(btn);
        }

        function onCardClick(e) {
            const card = e.currentTarget;
            if (e.target.closest('.remove')) return;
            currentSlot = Number(card.dataset.slot);
            renderQuestionsForSlot(currentSlot);
            openSheet(sheetQ);
        }

        // Gắn click cho các card có sẵn trong DOM
        grid.querySelectorAll('.qa-card').forEach(card => {
            card.addEventListener('click', onCardClick);
        });

        /* =======================
         *  ADD BUTTON LOGIC
         * ======================= */
        function areAllCardsFilled() {
            // Tất cả card hiện có đều đã có entry trong dataBySlot
            return Array.from(grid.querySelectorAll('.qa-card'))
                .every(card => dataBySlot.has(String(card.dataset.slot)));
        }

        function updateAddButton() {
            const uniqueAnswered = selectedQIds.size; // số câu hỏi đã dùng (unique)
            const canAddMore = uniqueAnswered < ALL.length; // còn câu chưa dùng không
            const allFilled = areAllCardsFilled(); // mọi card hiện có đều đã chọn

            if (canAddMore && allFilled) {
                addBtn.classList.remove('d-none');
                addBtn.removeAttribute('disabled');
            } else {
                addBtn.classList.add('d-none');
                addBtn.setAttribute('disabled', 'disabled');
            }
        }

        function nextSlotNumber() {
            // slot mới = max(data-slot hiện có) + 1 (không dồn/reindex)
            const slots = Array.from(grid.querySelectorAll('.qa-card')).map(el => Number(el.dataset.slot));
            return slots.length ? Math.max(...slots) + 1 : 1;
        }

        addBtn.addEventListener('click', () => {
            const uniqueAnswered = selectedQIds.size;
            // Chỉ cho thêm khi đáp ứng điều kiện
            if (!areAllCardsFilled() || uniqueAnswered >= ALL.length) return;

            const slot = nextSlotNumber();
            const wrapper = document.createElement('div');
            wrapper.className = 'qa-card';
            wrapper.dataset.slot = String(slot);
            wrapper.dataset.isRequired = 'false';
            wrapper.innerHTML = `<div class="qa-card-main"><span class="plus">+</span></div>`;
            wrapper.addEventListener('click', onCardClick);
            grid.appendChild(wrapper);

            // Ẩn nút ngay và mở chọn cho card mới
            updateAddButton();
            currentSlot = slot;
            renderQuestionsForSlot(currentSlot);
            openSheet(sheetQ);
        });

        /* =======================
         *  SYNC HIDDEN FIELD
         * ======================= */
        function syncHidden() {
            const ids = Array.from(dataBySlot.entries())
                .sort((a, b) => Number(a[0]) - Number(b[0]))
                .map(([, v]) => Number(v.answer_id));

            hiddenAnswer.value = JSON.stringify(ids);
            updateAddButton();

            // 🔔 Cho logger biết đã cập nhật danh sách answer
            hiddenAnswer.dispatchEvent(new Event('change', {
                bubbles: true
            }));
            hiddenAnswer.dispatchEvent(new CustomEvent('answersynced', {
                bubbles: true,
                detail: {
                    ids
                }
            }));
        }



        // Lần đầu vào: đảm bảo nút thêm ẩn cho đến khi người dùng chọn hết các card mặc định
        updateAddButton();

        /* =======================
         *  (Optional) PRESET từ server
         * =======================
         * const preset = @json($existingAnswers ?? []);
         * preset.forEach(({slot, question_id, question_title, answer_id, answer_text}) => {
         *   dataBySlot.set(String(slot), {question_id, question_title, answer_id, answer_text});
         *   selectedQIds.add(question_id);
         *   paintCard(slot);
         * });
         * syncHidden();
         */
    });
</script>
