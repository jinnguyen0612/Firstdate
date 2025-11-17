<script>
    $(document).ready(function() {
        // Handle the change event for notification_object
        $('#notification_object').on('change', function() {
            var selectedValue = $(this).val();
            console.log(selectedValue);
            // Hide both user and partner selects by default
            $('#user_select').hide();
            $('#partner_select').hide();

            // Load and show relevant select based on selection
            if (selectedValue === 'user') {
                $('#user_select').show();
                // Load data for user select
                select2LoadData($('#user_ids').data('url'), '#user_ids');
            } else if (selectedValue === 'partner') {
                $('#partner_select').show();
                // Load data for partner select
                select2LoadData($('#partner_ids').data('url'), '#partner_ids');
            } else if (selectedValue === 'only') {
                $('#user_select').show();
                $('#partner_select').show();
                // Load data for both user and partner selects
                select2LoadData($('#user_ids').data('url'), '#user_ids');
                select2LoadData($('#partner_ids').data('url'), '#partner_ids');
            }
            // No need to show anything if it's 'all'
        });

        $('#notification_object').trigger('change');
    });
</script>
