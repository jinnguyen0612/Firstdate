<script>
    $(document).ready(function() {
        $(".otp-form *:input[type!=hidden]:first").focus();

        let otp_fields = $(".otp-form .otp-field"),
            otp_value_field = $(".otp-form .otp-value");
        otp_fields
            .on("input", function(e) {
                $(this).val(
                    $(this)
                    .val()
                    .replace(/[^0-9]/g, "")
                );
                let opt_value = "";
                otp_fields.each(function() {
                    let field_value = $(this).val();
                    if (field_value != "") opt_value += field_value;
                });
                otp_value_field.val(opt_value);
            })
            .on("keyup", function(e) {
                let key = e.keyCode || e.which;

                // Backspace or Left
                if (key === 8 || key === 37) {
                    $(this).closest('.otp-container').prev().find('.otp-field').focus();
                }
                // Right or Enter or nếu đã nhập đủ ký tự thì tự next
                else if (key === 39 || $(this).val().length === 1) {
                    $(this).closest('.otp-container').next().find('.otp-field').focus();
                }
                if (key === 13 && otp_value_field.val().length === otp_fields.length) {
                    $('.otp-form').submit(); // hoặc gọi AJAX nếu muốn
                }
            })
            .on("paste", function(e) {
                let paste_data = e.originalEvent.clipboardData.getData("text").replace(/[^0-9]/g, "").slice(
                    0, otp_fields.length);
                paste_data.split("").forEach(function(value, index) {
                    otp_fields.eq(index).val(value);
                });
                otp_fields.eq(paste_data.length - 1).focus();
                otp_value_field.val(paste_data);
                e.preventDefault();
            });
    });
</script>
