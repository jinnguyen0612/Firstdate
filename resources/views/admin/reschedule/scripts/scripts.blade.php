<script>
    $(document).ready(function(e) {
        select2LoadData($('#classroom_id').data('url'), '#classroom_id');
        let classroomId;

        classroomId = $('#classroom_id').val();

        let urlDistrict = "{{ route('admin.search.select.session') }}";
        select2LoadData(urlWard + '?classroom_id=' + classroomId, '#old_session_id');
    });

    $(document).on('change', 'select[name="classroom_id"]', function(e) {
                    classroomId = $(this).val();
                    let url = "{{ route('admin.search.select.session') }}";
                    select2LoadData(url + '?classroom_id=' + classroomId, '#old_session_id');
                    $('#old_session_id').val(null).trigger('change');
    });
</script>
