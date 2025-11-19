<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('.currency-input');

        inputs.forEach(input => {
            // Chỉ cho phép nhập số
            input.addEventListener('keypress', function (e) {
                const char = String.fromCharCode(e.which);
                if (!/[0-9]/.test(char)) {
                    e.preventDefault();
                }
            });

            // Xử lý dán (paste)
            input.addEventListener('paste', function (e) {
                e.preventDefault();
                const pasted = (e.clipboardData || window.clipboardData).getData('text');
                const clean = pasted.replace(/[^\d]/g, '');
                document.execCommand('insertText', false, clean);
            });

            // Khi focus: bỏ dấu phẩy
            input.addEventListener('focus', function () {
                this.value = this.value.replace(/,/g, '');
            });

            // Khi blur: định dạng lại
            input.addEventListener('blur', function () {
                let rawValue = this.value.replace(/,/g, '').trim();
                if (rawValue !== '') {
                    this.value = formatCurrency(rawValue);
                }
            });

            // Khi gõ: định dạng realtime
            input.addEventListener('input', function (e) {
                const input = e.target;
                const selectionStart = input.selectionStart;

                let raw = input.value.replace(/\D/g, ''); // loại bỏ mọi ký tự không phải số
                let formatted = formatCurrency(raw);
                input.value = formatted;

                // Tính lại vị trí con trỏ
                let diff = formatted.length - raw.length;
                input.setSelectionRange(selectionStart + diff, selectionStart + diff);
            });
        });

        function formatCurrency(value) {
            // Thay dấu phân cách bằng dấu phẩy ,
            return value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        init();
        
        function init() {
            const inputs = document.querySelectorAll('.currency-input');
            inputs.forEach(input => {
                const rawValue = input.value.replace(/\D/g, '');
                input.value = formatCurrency(rawValue);
            });
        }
    });
</script>
