<script>
    function showFullImage(imgElement) {
        const modal = document.getElementById('image-modal');
        const fullImage = modal.querySelector('img');
        fullImage.src = imgElement.src; // hoặc dùng full URL nếu ảnh thu nhỏ khác ảnh gốc
        modal.style.display = 'flex';
    }

    function hideFullImage() {
        document.getElementById('image-modal').style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('image-modal').addEventListener('click', hideFullImage);
    });
</script>
