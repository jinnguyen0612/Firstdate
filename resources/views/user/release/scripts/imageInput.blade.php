<script>
  (function () {
    const inputFile        = document.querySelector("#picture_input");
    const pictureImage     = document.querySelector(".picture_image");
    const pictureContainer = document.querySelector(".picture");
    const subtitle         = document.getElementById("avatar-subtitle");

    if (!inputFile || !pictureImage || !pictureContainer || !subtitle) return;

    const defaultSubtitle = "Đây là ảnh hiển thị đầu tiên trong hồ sơ của bạn";
    const valueSubtitle   = "Trông bạn thật tuyệt 🫶";
    const emptyText       = "Choose an image";

    // Lưu lại HTML preview hợp lệ gần nhất
    let lastGoodHTML = pictureImage.innerHTML.trim();

    function setEmptyState() {
      pictureImage.dataset.empty = "true";
      pictureImage.textContent   = emptyText;
      pictureContainer.classList.add("border-custom");
      subtitle.textContent = defaultSubtitle;
    }

    // Khởi tạo
    (function init() {
      const hasInitialImg = !!pictureImage.querySelector("img");
      if (!hasInitialImg) {
        setEmptyState();
        lastGoodHTML = pictureImage.innerHTML;
      } else {
        pictureImage.dataset.empty = "false";
        pictureContainer.classList.remove("border-custom");
        subtitle.textContent = valueSubtitle;
      }
    })();

    // Helper: gán lại file vào input (đảm bảo FormData(form) có file)
    function setFileToInput(fileInput, file) {
      if (!(fileInput && file instanceof File)) return;
      const dt = new DataTransfer();
      dt.items.add(file);
      fileInput.files = dt.files; // giữ file trong input
      // nếu nơi khác cần bắt sự kiện đồng bộ:
      fileInput.dispatchEvent(new Event('filesynced', { bubbles: true }));
    }

    // Tip: cho phép chọn lại cùng 1 file vẫn kích hoạt "change"
    // bằng cách reset giá trị TRƯỚC khi mở hộp thoại chọn file.
    inputFile.addEventListener('click', () => {
      // chỉ reset khi chưa mở dialog; không ảnh hưởng FormData hiện có
      inputFile.value = '';
    });

    inputFile.addEventListener("change", (e) => {
      const file = e.target.files && e.target.files[0];

      // Người dùng bấm Cancel: giữ nguyên preview cũ
      if (!file) {
        if (!pictureImage.innerHTML.trim()) {
          pictureImage.innerHTML = lastGoodHTML;
        }
        return;
      }

      const reader = new FileReader();
      reader.onload = (ev) => {
        const src = String(ev.target?.result || "");
        const img = document.createElement("img");
        img.src = src;
        img.alt = "Preview";
        img.className = "picture_img";

        subtitle.textContent = valueSubtitle;
        pictureContainer.classList.remove("border-custom");
        pictureImage.replaceChildren(img);
        pictureImage.dataset.empty = "false";

        // Lưu lại preview hợp lệ
        lastGoodHTML = pictureImage.innerHTML;

        // Giữ file trong input để khi submit FormData(form) có 'avatar'
        setFileToInput(inputFile, file);

        // KHÔNG xoá inputFile.value ở đây nữa!
      };
      reader.readAsDataURL(file);
    });

    // (tuỳ chọn) nút xoá ảnh
    // document.getElementById("btn-clear")?.addEventListener("click", () => {
    //   setEmptyState();
    //   lastGoodHTML = pictureImage.innerHTML;
    //   // Nếu muốn xoá file khỏi input:
    //   inputFile.value = "";
    // });
  })();
</script>
