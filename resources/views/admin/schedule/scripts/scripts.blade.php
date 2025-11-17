<script>
    $(document).ready(function() {
        select2LoadData($('#student_id').data('url'), '#student_id');
        select2LoadData($('#teacher_id').data('url'), '#teacher_id');

        $('#type').change(function() {
            let selectedValue = $(this).val();
            if (selectedValue === 'one_to_one') {
                $('#max_student').val(1);
                $('#max_student').prop('readonly', true);

            } else {
                $('#max_student').val('');
                $('#max_student').prop('readonly', false);
            }
        });
    });
</script>
