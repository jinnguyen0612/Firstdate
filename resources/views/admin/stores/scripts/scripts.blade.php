<script>
    $(document).ready(function() {
        // Khởi tạo các biến và hằng số
        const STORE_API = {
            store: "{{ route('admin.store.store') }}",
            storeImage: "{{ route('admin.store.image.store') }}",
            delete: "{{ route('admin.store.delete', ':id') }}",
            deleteImage: "{{ route('admin.store.delete.image', ':id') }}"
        };

        // Xử lý thêm ảnh mới
        $('#add-image').on('click', function() {
            const currentCount = $('.image-group').length;
            const newImageGroup = `
                <div class="mb-3 image-group">
                    <div class="preview-container mb-2" style="display: none;">
                        <img src="" class="img-preview img-fluid rounded" style="max-height: 150px;">
                    </div>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="input-group">
                                <input type="file" class="form-control store-image" name="store_images[]" accept="image/*">
                                <button type="button" class="btn btn-danger remove-image">
                                    <i class="ti ti-x"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-8 mb-2">
                            <input type="text" class="form-control" name="captions[]" 
                                placeholder="{{ __('Chú thích ảnh (tùy chọn)') }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <input type="number" class="form-control display-order" name="display_orders[]" 
                                placeholder="{{ __('Thứ tự') }}" value="${currentCount}" min="0">
                        </div>
                    </div>
                </div>
            `;

            $('#images-container').append(newImageGroup);
            updateRemoveButtons();
        });

        // Xử lý preview ảnh khi chọn file
        $(document).on('change', '.store-image', function() {
            const imageGroup = $(this).closest('.image-group');
            const previewContainer = imageGroup.find('.preview-container');
            const imgPreview = previewContainer.find('.img-preview');

            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.attr('src', e.target.result);
                    previewContainer.show();
                }
                reader.readAsDataURL(this.files[0]);
            } else {
                previewContainer.hide();
            }
        });

        // Xử lý xóa ảnh
        $(document).on('click', '.remove-image', function() {
            $(this).closest('.image-group').remove();
            updateRemoveButtons();
            updateDisplayOrders();
        });

        // Cập nhật nút xóa
        function updateRemoveButtons() {
            const groups = $('.image-group');
            const removeButtons = $('.remove-image');
            groups.length > 1 ? removeButtons.show() : removeButtons.hide();
        }

        // Cập nhật thứ tự hiển thị
        function updateDisplayOrders() {
            $('.display-order').each(function(index) {
                $(this).val(index);
            });
        }

        // Xử lý form submit
        $('form').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            // Thêm dữ liệu hình ảnh vào FormData
            $('.image-group').each(function(index) {
                const imageFile = $(this).find('input[type="file"]')[0].files[0];
                const caption = $(this).find('input[name="captions[]"]').val();
                const order = $(this).find('input[name="display_orders[]"]').val();

                if (imageFile) {
                    formData.append(`store_images[${index}][file]`, imageFile);
                    formData.append(`store_images[${index}][caption]`, caption);
                    formData.append(`store_images[${index}][display_order]`, order);
                }
            });

            $.ajax({
                url: STORE_API.store,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed && response.redirect) {
                                window.location.href = response.redirect;
                            }
                        });
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                }
            });
        });

        // Xử lý lỗi AJAX
        function handleAjaxError(xhr) {
            let errorMessage = '';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                $.each(xhr.responseJSON.errors, function(key, value) {
                    errorMessage += value[0] + '\n';
                });
            } else {
                errorMessage = 'Có lỗi xảy ra, vui lòng thử lại.';
            }

            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: errorMessage
            });
        }

        // Khởi tạo
        updateRemoveButtons();
    });
</script>
