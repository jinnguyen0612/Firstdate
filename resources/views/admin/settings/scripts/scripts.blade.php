<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('.percentage-input');

        inputs.forEach(input => {
            // Không cho nhập ngoài số và dấu chấm
            input.addEventListener('keypress', function (e) {
                const char = String.fromCharCode(e.which);
                const isValid = /[0-9.]/.test(char);
                if (!isValid) {
                    e.preventDefault();
                }
            });

            // Xử lý khi dán (paste): loại bỏ ký tự không hợp lệ
            input.addEventListener('paste', function (e) {
                e.preventDefault();
                const pasted = (e.clipboardData || window.clipboardData).getData('text');
                const clean = pasted.replace(/[^\d.]/g, '');
                document.execCommand('insertText', false, clean);
            });

            // Khi focus: bỏ dấu %
            input.addEventListener('focus', function () {
                this.value = this.value.replace('%', '').trim();
            });

            // Khi blur: gắn lại dấu %
            input.addEventListener('blur', function () {
                let rawValue = this.value.replace('%', '').trim();
                rawValue = rawValue.replace(/[^\d.]/g, '');
                if (rawValue !== '') {
                    this.value = rawValue + '%';
                }
            });
        });
    });
</script>
