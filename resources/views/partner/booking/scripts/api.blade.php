<script>
    function toProcessing(bookingId) {
        fetch(`{{ route('partner.booking.toProcessing', '') }}/${bookingId}`, {
                method: 'GET'
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
                        window.location.reload();
                    }, 1000);
                } else {
                    $.toast({
                        heading: 'Lỗi',
                        text: data.message || 'Không thể cập nhật trạng thái',
                        icon: 'error',
                        position: 'top-right',
                        hideAfter: 5000
                    });
                }
            }).catch(err => console.error(err));
    }

    function acceptReject(rejectFormData) {
        fetch('{{ route('partner.booking.reject') }}', {
                method: 'POST',
                body: rejectFormData
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
                        window.location.reload();
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
    }

    function accept(acceptFormData) {
        fetch('{{ route('partner.booking.accept') }}', {
                method: 'POST',
                body: acceptFormData
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
                        window.location.reload();
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
    }

    function acceptConfirmCancel(cancelFormData, modal) {
        fetch('{{ route('partner.booking.acceptCancel') }}', {
                method: 'POST',
                body: cancelFormData
            }).then(res => res.json())
            .then(data => {
                if (data.status === 200) {
                    console.log('success');
                    $.toast({
                        heading: 'Thành công',
                        text: data.message,
                        icon: 'success',
                        position: 'top-right',
                        bgColor: '#28a745',
                        textColor: '#fff',
                        hideAfter: 3000
                    });
                    modal.hide(); // đóng modal confirm
                    
                    setTimeout(function() {
                        console.log('reload');
                        window.location.reload();
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
    }

    function completed(completedFormData) {
        fetch('{{ route('partner.booking.completed') }}', {
                method: 'POST',
                body: completedFormData
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
                        window.location.reload();
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
    }
</script>
