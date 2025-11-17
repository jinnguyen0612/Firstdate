<script>
    $(document).ready(function() {
        select2LoadData($('#user_id').data('url'), '#user_id');
        select2LoadData($('#subadmin_id').data('url'), '#subadmin_id');
        // Hiển thị mặc định chỉ phần khách hàng
        $('#notification-customer-select').show();
        $('#notification-subadmin-select').show();

        $('.notification-type').change(function() {
            let selectedValue = $(this).val();
            if (selectedValue === 'customer') {
                $('#notification-customer-select').show();
                $('#notification-subadmin-select').hide();
            } else if (selectedValue === 'subadmin') {
                $('#notification-customer-select').hide();
                $('#notification-subadmin-select').show();
            } else {
                $('#notification-customer-select').hide();
                $('#notification-subadmin-select').hide();
            }
        });
    });
</script>
