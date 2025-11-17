<script>
    document.addEventListener("DOMContentLoaded", function () {
        const radios = document.querySelectorAll('input[name="reason"]');
        const noteInput = document.querySelector('input[name="note"]');
        const reasonDifferent = document.getElementById('reasonDifferent');

        radios.forEach(radio => {
            radio.addEventListener("change", function () {
                if (reasonDifferent.checked) {
                    noteInput.type = "text";
                    noteInput.value = "";
                    noteInput.focus();
                } else {
                    // Nếu chọn lý do có sẵn thì ẩn và set value
                    noteInput.type = "hidden";
                    noteInput.value = this.value;
                }
            });
        });
    });
</script>
