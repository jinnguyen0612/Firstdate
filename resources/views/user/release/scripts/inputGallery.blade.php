<script>
    document.addEventListener('DOMContentLoaded', () => {
        const grid = document.getElementById('imageGrid');
        const picker = document.getElementById('filePicker');
        const slots = Array.from(grid.querySelectorAll('.image-slot'));

        // State ảnh theo index
        // images[i]: string (dataURL/URL để preview)
        // files[i]:  File | null (chỉ có với ảnh người dùng chọn/kéo-thả)
        const images = slots.map(slot => {
            const img = slot.querySelector('img.preview');
            return img ? img.src : null;
        });
        const files = slots.map(() => null);

        let lastClickedIndex = 0;

        // --- Helpers ---
        function dataURLToFile(dataURL, filename = 'image.png') {
            const [hdr, b64] = dataURL.split(',');
            const mime = (hdr.match(/data:(.*?);base64/) || [])[1] || 'image/png';
            const bin = atob(b64);
            const len = bin.length;
            const u8 = new Uint8Array(len);
            for (let i = 0; i < len; i++) u8[i] = bin.charCodeAt(i);
            return new File([u8], filename, {
                type: mime
            });
        }

        function toDataURL(file) {
            return new Promise((res, rej) => {
                const fr = new FileReader();
                fr.onload = () => res(String(fr.result || ''));
                fr.onerror = rej;
                fr.readAsDataURL(file);
            });
        }

        // Gán lại FileList cho <input type="file"> bằng DataTransfer
        function updateFileInput() {
            const dt = new DataTransfer();
            files.forEach(f => {
                if (f) dt.items.add(f);
            });
            picker.files = dt.files;

            // Báo cho các script khác biết FileList đã sync
            picker.dispatchEvent(new CustomEvent('filesynced', {
                bubbles: true
            }));
        }


        // --- Render ---
        function renderSlot(i) {
            const slot = slots[i];
            const src = images[i];
            if (src) {
                slot.classList.add('filled');
                slot.innerHTML = `
        <img class="preview" src="${src}" alt="preview">
        <button class="remove" type="button">Xóa</button>
      `;
            } else {
                slot.classList.remove('filled');
                slot.innerHTML = `<span class="plus">+</span>`;
            }
        }

        function renderAll() {
            for (let i = 0; i < slots.length; i++) renderSlot(i);
        }

        // --- Click mở file picker ---
        grid.addEventListener('click', (e) => {
            if (e.target.closest('.remove')) return;
            const slot = e.target.closest('.image-slot');
            if (!slot) return;
            lastClickedIndex = Number(slot.dataset.index || 0);
            picker.click();
        });

        // --- Xoá & dồn trái ---
        grid.addEventListener('click', (e) => {
            const btn = e.target.closest('.remove');
            if (!btn) return;
            e.stopImmediatePropagation();
            e.preventDefault();

            const slot = btn.closest('.image-slot');
            const index = Number(slot.dataset.index || 0);

            // shift-left cả images & files
            for (let i = index; i < images.length - 1; i++) {
                images[i] = images[i + 1];
                files[i] = files[i + 1];
            }
            images[images.length - 1] = null;
            files[files.length - 1] = null;

            renderAll();
            updateFileInput(); // <— cập nhật FileList
        });

        // --- Drag & Drop từng ô ---
        grid.addEventListener('dragover', (e) => e.preventDefault());
        grid.addEventListener('drop', async (e) => {
            e.preventDefault();
            const slot = e.target.closest('.image-slot');
            if (!slot) return;
            const file = e.dataTransfer?.files?.[0];
            if (!file) return;

            const i = Number(slot.dataset.index || 0);
            const dataURL = await toDataURL(file);

            images[i] = dataURL;
            files[i] = file; // giữ File gốc để submit
            renderSlot(i);
            updateFileInput(); // <— cập nhật FileList
        });

        // --- Chọn ảnh từ picker ---
        picker.addEventListener('change', async (e) => {
            const chosenFiles = Array.from(e.target.files || []);
            picker.value = ''; // cho phép chọn lại cùng file vẫn trigger change
            if (!chosenFiles.length) return;

            const dataURLs = await Promise.all(chosenFiles.map(toDataURL));
            const [firstURL, ...restURLs] = dataURLs;

            // 1) Ảnh đầu tiên đặt đúng vị trí vừa bấm
            images[lastClickedIndex] = firstURL;
            files[lastClickedIndex] = chosenFiles[0];

            // 2) Ảnh còn lại -> rải vào ô trống
            const n = images.length;
            const empties = [];
            for (let k = lastClickedIndex + 1; k < n; k++)
                if (!images[k]) empties.push(k);
            for (let k = 0; k < lastClickedIndex; k++)
                if (!images[k]) empties.push(k);

            for (let i = 0; i < restURLs.length && i < empties.length; i++) {
                const idx = empties[i];
                images[idx] = restURLs[i];
                files[idx] = chosenFiles[i + 0 + 1]; // (bỏ file đầu)
            }

            renderAll();
            updateFileInput(); // <— cập nhật FileList
        });

        // Init
        renderAll();
        updateFileInput(); // khởi tạo FileList (sẽ rỗng nếu chưa chọn)
    });
</script>
