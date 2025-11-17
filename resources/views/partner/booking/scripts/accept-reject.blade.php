<script>
    $(document).ready(function() {
        $("#btn-accept-reject").on("click", function() {
            let rejectFormData = new FormData();

            rejectFormData.append('_token', $('meta[name="X-TOKEN"]').attr('content'));
            rejectFormData.append('id', $('input[name=id]').val());
            rejectFormData.append('note', $('input[name=note]').val());
            

            acceptReject(rejectFormData);
        });
    });
</script>
