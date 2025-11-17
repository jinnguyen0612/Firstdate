<script>
    $(document).ready(function () {
        const PROGRESS_OFFSET = 0.12;
        const NORMAL_SPEED = 'transform 0.55s ease';
        const LAST_SLIDE_SPEED = 'transform 1.5s ease';

        function updateProgressBar(currentIndex, total) {
            const el = document.querySelector('.swiper-pagination-progressbar-fill');
            if (!el) return;

            let progress = (currentIndex + 1) / total;

            if (currentIndex !== total - 1) {
                progress -= PROGRESS_OFFSET;
                el.style.transition = NORMAL_SPEED;
            } else {
                el.style.transition = LAST_SLIDE_SPEED;
            }

            // Đảm bảo không âm
            progress = Math.max(0, progress);
            el.style.transform = `scaleX(${progress})`;
        }

        function updatePaginationSwitch(activeIndex) {
            const $switches = $(".swiper-pagination-custom .swiper-pagination-switch");
            $switches.removeClass("active");
            $switches.eq(activeIndex).addClass("active");
        }

        var mySwiper = new Swiper(".swiper", {
            autoHeight: true,
            autoplay: false,
            speed: 500,
            direction: "horizontal",
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                type: "progressbar",
            },
            loop: false,
            effect: "slide",
            spaceBetween: 0,
            on: {
                init: function () {
                    const total = this.slides.length;
                    const current = this.realIndex;

                    updateProgressBar(current, total);
                    updatePaginationSwitch(current);
                },
                slideChangeTransitionStart: function () {
                    const total = this.slides.length;
                    const current = this.realIndex;

                    updateProgressBar(current, total);
                    updatePaginationSwitch(current);
                },
            },
        });

        $(".swiper-pagination-custom .swiper-pagination-switch").each(function (index) {
            $(this).on("click", function () {
                if ($(this).hasClass("disabled")) return;
                mySwiper.slideTo(index);
                updatePaginationSwitch(index);
            });
        });
    });
</script>
