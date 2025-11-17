<script>
    function copyToClipboard(copyText) {
        navigator.clipboard.writeText(copyText);
    }

    $(document).ready(function() {
        const hourField = $(".hour-field");
        const minuteField = $(".minute-field");
        const timeValueField = $(".time-value");

        function format2Digit(val) {
            val = val.replace(/[^0-9]/g, '');
            if (val.length === 1) return '0' + val;
            return val.slice(0, 2); // chỉ lấy 2 số đầu
        }

        function updateHiddenValue() {
            const h = format2Digit(hourField.val());
            const m = format2Digit(minuteField.val());
            timeValueField.val(`${h}:${m}`);
        }

        hourField.on("input", function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 2);
            if (this.value.length === 2) {
                minuteField.focus();
            }
            updateHiddenValue();
        });

        minuteField.on("input", function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 2);
            updateHiddenValue();
        });

        hourField.on("blur", function() {
            this.value = format2Digit(this.value);
            updateHiddenValue();
        });

        minuteField.on("blur", function() {
            this.value = format2Digit(this.value);
            updateHiddenValue();
        });

        hourField.on("paste", function(e) {
            let pasteData = e.originalEvent.clipboardData.getData("text").replace(/[^0-9]/g, '');
            if (pasteData.length >= 4) {
                hourField.val(pasteData.slice(0, 2));
                minuteField.val(pasteData.slice(2, 4));
                minuteField.focus();
            } else if (pasteData.length === 2) {
                hourField.val(pasteData);
                minuteField.focus();
            }
            updateHiddenValue();
            e.preventDefault();
        });

        $(".time-form *:input[type!=hidden]:first").focus();

        $("#btn-accept").on("click", function() {
            let acceptFormData = new FormData();

            acceptFormData.append('_token', $('meta[name="X-TOKEN"]').attr('content'));
            acceptFormData.append('code', $('input[name=code]').val());
            acceptFormData.append('from', $('input[name=from]').val());
            acceptFormData.append('to', $('input[name=to]').val());
            acceptFormData.append('time', $('input[name=time-value]').val());
            acceptFormData.append('partner_table_id', $('select[name=partner_table_id]').val());

            accept(acceptFormData);
        });

        let cancelName = [];
        let cancelFormData = new FormData();
        let confirmInstance;

        $("#btn-accept-cancel").on("click", function() {
            cancelName = []; // reset
            cancelFormData = new FormData(); // reset

            let modalEl = document.getElementById("cancelModal");
            let modalInstance = bootstrap.Modal.getInstance(modalEl);

            cancelFormData.append(
                "_token",
                $('meta[name="X-TOKEN"]').attr("content")
            );
            cancelFormData.append("id", $("input[name=id]").val());

            $('input[name="checkbox[]"]:checked').each(function() {
                let selected = $(this).val(); // "id|name"
                let [id, name] = selected.split("|");
                cancelName.push(name);
                cancelFormData.append("checkbox[]", id);
            });

            if (cancelName.length === 0) {
                $.toast({
                    heading: 'Lỗi',
                    text: 'Vui lòng chọn ít nhất một người để hủy.',
                    icon: 'error',
                    position: 'top-right',
                    hideAfter: 5000
                });
                return;
            }

            let confirmEl = document.getElementById("confirmCancelModal");
            confirmInstance = new bootstrap.Modal(confirmEl);

            // Hiển thị danh sách người sẽ hủy trong modal confirm
            $("#confirmCancelContent").html(
                `<p>Bạn xác nhận hủy bởi: <b>${cancelName.join(", ")}</b> ?</p>`
            );

            modalInstance.hide(); // đóng modal chọn người
            confirmInstance.show(); // mở modal confirm
        });

        $("#btn-accept-confirm-cancel").on("click", function() {
            cancelFormData.append("reason", $("input[name=reason]").val());

            acceptConfirmCancel(cancelFormData, confirmInstance);
        });

        $('#cancelModal').on('hidden.bs.modal', function() {
            $('input[name="checkbox[]"]').prop('checked', false);
        });

        $('#btn-processing').on("click", function(e) {
            e.preventDefault();
            bookingId = $('input[name=id]').val()
            toProcessing(bookingId);
        })

        $('#btn-completed').on("click", function(e) {
            e.preventDefault();
            let completedFormData = new FormData();

            completedFormData.append('_token', $('meta[name="X-TOKEN"]').attr('content'));
            completedFormData.append('id', $('input[name=id]').val());
            completedFormData.append('total', $('input[name=total]').val());
            completedFormData.append('invoice', $('input[name=invoice]').prop('files')[0]);

            completed(completedFormData);
        });
    });
</script>
