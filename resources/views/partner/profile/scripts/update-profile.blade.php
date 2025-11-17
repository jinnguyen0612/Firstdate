<script>
    document.getElementById("btnUpdateProfile").addEventListener("click", function() {
        const inputFile = document.getElementById("picture__input");
        let formData = new FormData();

        formData.append("_token", $('meta[name="X-TOKEN"]').attr('content'));

        // Thu thập dữ liệu
        const file = inputFile.files[0];
        if (file) formData.append("avatar", file);

        formData.append("name", document.getElementById("name").value);
        formData.append("province", document.querySelector("[name='province']").value);
        formData.append("district", document.querySelector("[name='district']").value);
        formData.append("lat", document.querySelector("[name='lat']").value);
        formData.append("lng", document.querySelector("[name='lng']").value);
        formData.append("address", document.getElementById("address").value);
        formData.append("partner_category_id", document.getElementById("partner_category_id").value);
        formData.append("description", document.querySelector("[name='description']").value);

        fetch("{{ route('partner.profile.updateProfile') }}", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status == 200) {
                    $.toast({
                        heading: 'Thành công',
                        text: data.message,
                        icon: 'success',
                        position: 'top-right',
                        bgColor: '#28a745',
                        textColor: '#fff',
                        hideAfter: 3000
                    });
                } else {
                    $.toast({
                        heading: 'Lỗi',
                        text: data.message || 'Không thể cập nhật',
                        icon: 'error',
                        position: 'top-right',
                        hideAfter: 5000
                    });
                    if (data.message_validate) {
                        $.toast({
                            heading: 'Lỗi',
                            text: data.message_validate,
                            icon: 'error',
                            position: 'top-right',
                            hideAfter: 5000
                        });
                        return;
                    }

                }
            })
            .catch(err => {
                console.error(err);
                $.toast({
                    heading: 'Thất bại',
                    text: 'Đã có lỗi xảy ra',
                    icon: 'error',
                    position: 'top-right',
                    hideAfter: 5000
                });
            });
    });
</script>
