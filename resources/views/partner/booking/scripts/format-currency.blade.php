<script>
    const profitSplit = {{ $settings->where('setting_key', 'profit_split')->pluck('plain_value')->first() }};
    let profit = 0;

    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('.currency-input');
        const profitDisplay = document.getElementById('profit-display');

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
                updateProfit();
            });

            // Khi gõ: định dạng realtime + tính profit
            input.addEventListener('input', function (e) {
                const input = e.target;
                const selectionStart = input.selectionStart;

                let raw = input.value.replace(/\D/g, ''); // loại bỏ mọi ký tự không phải số
                let formatted = formatCurrency(raw);
                input.value = formatted;

                // Tính lại vị trí con trỏ
                let diff = formatted.length - raw.length;
                input.setSelectionRange(selectionStart + diff, selectionStart + diff);

                updateProfit();
            });
        });

        function formatCurrency(value) {
            return value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        function updateProfit() {
            let total = 0;
            inputs.forEach(input => {
                let raw = input.value.replace(/,/g, '').trim();
                if (raw !== '') {
                    total += parseInt(raw);
                }
            });
            profit = Math.round(total * profitSplit / 100); // tính profit
            profitDisplay.textContent = formatCurrency(profit.toString());
        }

        // Khởi tạo ban đầu
        init();
        
        function init() {
            inputs.forEach(input => {
                const rawValue = input.value.replace(/\D/g, '');
                input.value = formatCurrency(rawValue);
            });
            updateProfit();
        }
    });
</script>