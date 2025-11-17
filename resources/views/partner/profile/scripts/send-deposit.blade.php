<script>
    document.querySelector('.btnComplete').addEventListener('click', function() {
        let formData = new FormData();
        let fileInput = document.getElementById('imageInput').files[0];

        formData.append('_token', $('meta[name="X-TOKEN"]').attr('content'));
        formData.append('amount', document.querySelector('input[name=amount]').value);
        formData.append('description', document.querySelector('input[name=description]').value);
        if (fileInput) {
            formData.append('image', fileInput);
        }

        fetch('{{ route('partner.profile.sendDeposit') }}', {
                method: 'POST',
                body: formData
            }).then(res => res.json())
            .then(data => {
                if (data.status === 200) {
                    $.toast({
                        heading: 'Thành công',
                        text: data.message,
                        icon: 'success',
                        position: 'top-right',
                        bgColor: '#28a745',
                        textColor: '#fff',
                        hideAfter: 3000
                    });
                    setTimeout(function() {
                        let urlTemplate =
                            '{{ route('partner.profile.transaction.detail', ['code' => '___CODE___']) }}';
                        window.location.href = urlTemplate.replace('___CODE___', data.transaction
                            .code);
                    }, 1000);

                } else {
                    if (data.message_validate) {
                        // Lặp qua tất cả key (field)
                        let allMessages = [];
                        Object.values(data.message_validate).forEach(errors => {
                            allMessages = allMessages.concat(errors);
                        });

                        $.toast({
                            heading: 'Lỗi',
                            text: allMessages.join('<br>'),
                            icon: 'error',
                            position: 'top-right',
                            hideAfter: 5000
                        });
                    } else {
                        $.toast({
                            heading: 'Lỗi',
                            text: data.message || 'Không thể cập nhật',
                            icon: 'error',
                            position: 'top-right',
                            hideAfter: 5000
                        });
                    }
                }
            }).catch(err => console.error(err));
    });
</script>
