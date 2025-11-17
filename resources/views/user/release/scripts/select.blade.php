<script>
    (() => {
        // Map label từ PHP để hiển thị text đẹp
        const RELATIONSHIP_LABELS = @json($relationships ?? [], JSON_UNESCAPED_UNICODE);
        const DATINGTIME_LABELS = @json($datingTime ?? [], JSON_UNESCAPED_UNICODE);

        const root = document.getElementById('fdSheetRoot');
        const backdrop = document.getElementById('fdBackdrop');

        const sheetLF = document.getElementById('sheetLookingFor');
        const btnLF = document.getElementById('btnLookingFor');
        const textLF = document.getElementById('textLookingFor');
        const valLF = document.getElementById('valLookingFor');

        const sheetRel = document.getElementById('sheetRel');
        const btnRel = document.getElementById('btnRel');
        const textRel = document.getElementById('textRel');
        const valRel = document.getElementById('valRel');
        const relOk = document.getElementById('relOk');

        const sheetDatingTime = document.getElementById('sheetDatingTime');
        const btnDatingTime = document.getElementById('btnDatingTime');
        const textDatingTime = document.getElementById('textDatingTime');
        const valDatingTime = document.getElementById('valDatingTime');
        const datingTimeOk = document.getElementById('datingTimeOk');

        function openSheet(el) {
            backdrop.classList.add('open');
            el.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeAll() {
            document.querySelectorAll('.fd-sheet.open').forEach(s => s.classList.remove('open'));
            backdrop.classList.remove('open');
            document.body.style.overflow = '';
        }

        // Triggers trong .mb-3
        btnLF.addEventListener('click', () => openSheet(sheetLF));
        btnRel.addEventListener('click', () => openSheet(sheetRel));
        btnDatingTime.addEventListener('click', () => openSheet(sheetDatingTime));

        // Close buttons + backdrop + ESC
        root.addEventListener('click', (e) => {
            if (e.target.matches('[data-close]')) closeAll();
        });
        backdrop.addEventListener('click', closeAll);
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeAll();
        });

        // SINGLE select (looking_for)
        sheetLF.querySelector('.fd-sheet-list').addEventListener('click', (e) => {
            const li = e.target.closest('li[data-value]');
            if (!li) return;
            valLF.value = li.dataset.value;
            valLF.dispatchEvent(new Event('change', {
                bubbles: true
            }));

            textLF.textContent = li.textContent.trim();
            textLF.classList.remove('fd-placeholder');
            closeAll();
        });

        // MULTI select (relationships)
        relOk.addEventListener('click', () => {
            const checked = Array.from(sheetRel.querySelectorAll('input[type="checkbox"]:checked'))
                .map(i => i.value);
            valRel.value = checked.join(',');
            // 🔔 Báo đã đổi relationship
            valRel.dispatchEvent(new Event('change', {
                bubbles: true
            }));

            textRel.textContent = checked.length ?
                checked.map(v => RELATIONSHIP_LABELS[v] || v).join(', ') :
                (textRel.getAttribute('data-placeholder') || textRel.textContent);
            textRel.classList.toggle('fd-placeholder', checked.length === 0);
            closeAll();
        });

        // MULTI select (dating_time)
        datingTimeOk.addEventListener('click', () => {
            const checked = Array.from(sheetDatingTime.querySelectorAll('input[type="checkbox"]:checked'))
                .map(i => i.value);
            valDatingTime.value = checked.join(',');
            // 🔔 Báo đã đổi dating_time
            valDatingTime.dispatchEvent(new Event('change', {
                bubbles: true
            }));

            textDatingTime.textContent = checked.length ?
                checked.map(v => DATINGTIME_LABELS[v] || v).join(', ') :
                (textDatingTime.getAttribute('data-placeholder') || textDatingTime.textContent);
            textDatingTime.classList.toggle('fd-placeholder', checked.length === 0);
            closeAll();
        });

        // Vuốt xuống để đóng (đơn giản)
        [sheetLF, sheetRel, sheetDatingTime].forEach(s => {
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
    })();
</script>
