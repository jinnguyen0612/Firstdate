// Lấy nút
let backToTopBtn = document.getElementById("backToTopBtn");

// Hiển thị nút khi người dùng cuộn xuống 20px từ đầu trang
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        backToTopBtn.style.display = "block";
    } else {
        backToTopBtn.style.display = "none";
    }
}

// Khi người dùng nhấp vào nút, cuộn lên đầu trang
function topFunction() {
    document.body.scrollTop = 0; // Cho Safari
    document.documentElement.scrollTop = 0; // Cho Chrome, Firefox, IE và Opera
}
