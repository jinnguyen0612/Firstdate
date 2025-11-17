<script>
    const inputFile = document.querySelector("#picture__input");
    const pictureImage = document.querySelector(".picture__image");
    const pictureImageTxt = "Choose an image";
    pictureImage.innerHTML = pictureImageTxt;

    function showImage(url) {
        const img = document.createElement("img");
        img.src = url;
        img.classList.add("picture__img");
        pictureImage.innerHTML = "";
        pictureImage.appendChild(img);
    }

    // Hiển thị ảnh mặc định nếu có
    document.addEventListener("DOMContentLoaded", () => {
        const defaultImage = inputFile.dataset.default;
        if (defaultImage) {
            showImage(defaultImage);
        }
    });

    // Xử lý khi chọn file mới
    inputFile.addEventListener("change", function(e) {
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.addEventListener("load", function(e) {
                showImage(e.target.result);
            });
            reader.readAsDataURL(file);
        } else {
            pictureImage.innerHTML = pictureImageTxt;
        }
    });
</script>
