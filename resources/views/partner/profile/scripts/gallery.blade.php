<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadInput = document.querySelector('.image-upload-container input');
        const photosSection = document.querySelector('#photos');
        const contextMenu = document.getElementById('imageContextMenu');
        let currentImageIndex = null; // để lưu ảnh đang click

        let gallery = [
            @if (session('gallery'))
                @foreach (session('gallery') as $img)
                    "{{ asset($img) }}",
                @endforeach
            @endif
            @if ($currentPartner->gallery)
                @foreach ($currentPartner->gallery as $item)
                    "{{ asset($item) }}",
                @endforeach
            @endif
        ];

        function renderGallery() {
            // Xóa ảnh cũ (chừa lại khung upload)
            photosSection.querySelectorAll('img').forEach(el => el.remove());

            gallery.forEach((src, index) => {
                const img = document.createElement('img');
                img.src = src;
                img.classList.add('img-fluid');
                img.style.cursor = 'pointer';

                // Chuột phải (desktop)
                img.addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                    currentImageIndex = index;
                    showContextMenu(e.pageX, e.pageY);
                });

                // Long press (mobile)
                let pressTimer;
                img.addEventListener('touchstart', function(e) {
                    pressTimer = setTimeout(() => {
                        currentImageIndex = index;
                        const touch = e.touches[0];
                        showContextMenu(touch.pageX, touch.pageY);
                    }, 600);
                });

                img.addEventListener('touchend', function() {
                    clearTimeout(pressTimer);
                });

                photosSection.appendChild(img);
            });
        }

        function showContextMenu(x, y) {
            const menuWidth = contextMenu.offsetWidth || 150; // nếu chưa render thì tạm set 150px
            const menuHeight = contextMenu.offsetHeight || 80; // tạm set chiều cao
            const winWidth = window.innerWidth;
            const winHeight = window.innerHeight;

            let posX = x;
            let posY = y;

            // Nếu tràn ngang bên phải
            if (x + menuWidth > winWidth) {
                posX = x - menuWidth;
                if (posX < 0) posX = 0; // nếu vẫn âm thì fix sát trái
            }

            // Nếu tràn dọc bên dưới
            if (y + menuHeight > winHeight) {
                posY = y - menuHeight;
                if (posY < 0) posY = 0; // fix sát trên
            }

            contextMenu.style.left = posX + 'px';
            contextMenu.style.top = posY + 'px';
            contextMenu.style.display = 'block';
        }

        // Ẩn context menu khi click ngoài
        document.addEventListener('click', function(e) {
            if (!contextMenu.contains(e.target)) {
                contextMenu.style.display = 'none';
            }
        });

        // Xử lý click menu "Xem ảnh"
        document.getElementById('showImageBtn').addEventListener('click', function(e) {
            e.preventDefault();
            if (currentImageIndex !== null) {
                showFullImageSrc(gallery[currentImageIndex]);
            }
            contextMenu.style.display = 'none';
        });

        // Xử lý click menu "Xóa ảnh"
        document.getElementById('deleteImageBtn').addEventListener('click', function(e) {
            e.preventDefault();
            if (currentImageIndex !== null) {
                gallery.splice(currentImageIndex, 1);
                renderGallery();
            }
            contextMenu.style.display = 'none';
        });

        // Hàm xem ảnh full
        function showFullImageSrc(src) {
            const modal = document.getElementById('image-modal');
            const fullImage = modal.querySelector('img');
            fullImage.src = src;
            modal.style.display = 'flex';
        }

        // Click dấu + để upload
        photosSection.querySelector('.image-upload-container .image')
            .addEventListener('click', function() {
                uploadInput.click();
            });

        // Khi chọn ảnh mới
        uploadInput.addEventListener('change', function() {
            const files = Array.from(this.files);
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    gallery.push(e.target.result);
                    renderGallery();
                };
                reader.readAsDataURL(file);
            });
            this.value = '';
        });

        renderGallery();

        document.getElementById("btnUpdateGallery").addEventListener("click", function() {

            let formData = new FormData();

            formData.append("_token", $('meta[name="X-TOKEN"]').attr('content'));

            formData.append("gallery", JSON.stringify(gallery));

            fetch("{{ route('partner.profile.updateGallery') }}", {
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

    });
</script>
