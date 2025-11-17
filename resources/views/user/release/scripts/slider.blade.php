<script>
    // -----------------------------
    // Slider state & DOM references
    // -----------------------------
    let currentSlide = 0;
    const slides = document.querySelectorAll(".slide");
    const dots = document.querySelectorAll(".dot");
    const sliderEl = document.querySelector(".slide-container");

    // -----------------------------
    // Show login
    // -----------------------------
    function showLogin(){
        document.getElementById('welcome').classList.add('d-none');
        document.getElementById('login').classList.remove('d-none');
        document.querySelector('body').classList.add('bg-login');
    }

    // -----------------------------
    // Core render
    // -----------------------------
    const init = (n) => {
        slides.forEach((slide) => {
            slide.style.display = "none";
            slide.classList.remove("show");
        });

        dots.forEach((dot) => dot.classList.remove("active"));

        if (slides[n]) {
            slides[n].classList.add("show");
            slides[n].style.display = "block";
        }
        if (dots[n]) {
            dots[n].classList.add("active");
        }
    };

    // -----------------------------
    // Navigation
    // -----------------------------
    function next() {
        if (currentSlide >= slides.length - 1){
            showLogin();
            return;
        };
        currentSlide++;
        init(currentSlide);
    }

    const prev = () => {
        if (currentSlide <= 0) return;
        currentSlide--;
        init(currentSlide);
    };

    // -----------------------------
    // Swipe recognizer
    // -----------------------------
    function createSwipeRecognizer(
        container, {
            threshold = 48,
            fastMs = 450,
            fastThreshold = 24
        } = {}
    ) {
        if (!container) return () => {};

        // Allow vertical scroll; we'll prevent default on horizontal drags.
        if (!container.style.touchAction) container.style.touchAction = "pan-y";
        if (!container.style.userSelect) container.style.userSelect = "none";

        let startX = 0;
        let startY = 0;
        let dx = 0;
        let dy = 0;
        let startTime = 0;
        let dragging = false;
        let lockedAxis = null; // 'x' | 'y'

        const fire = (type, detail) => {
            container.dispatchEvent(
                new CustomEvent(type, {
                    bubbles: true,
                    detail
                })
            );
        };

        const onDown = (e) => {
            if (e.isPrimary === false) return;
            const p = e.touches ? e.touches[0] : e;
            startX = p.clientX;
            startY = p.clientY;
            startTime = Date.now();
            dx = 0;
            dy = 0;
            dragging = true;
            lockedAxis = null;
        };

        const onMove = (e) => {
            if (!dragging) return;
            const p = e.touches ? e.touches[0] : e;
            dx = p.clientX - startX;
            dy = p.clientY - startY;

            if (!lockedAxis && (Math.abs(dx) > 8 || Math.abs(dy) > 8)) {
                lockedAxis = Math.abs(dx) > Math.abs(dy) ? "x" : "y";
            }
            // If we're dragging horizontally, block vertical scroll.
            if (lockedAxis === "x") e.preventDefault();
        };

        const onUp = () => {
            if (!dragging) return;
            dragging = false;

            const elapsed = Date.now() - startTime;
            const useTh = elapsed < fastMs ? fastThreshold : threshold;
            const velocityX = dx / Math.max(1, elapsed); // px/ms (for reference)

            if (lockedAxis === "x") {
                if (dx <= -useTh) {
                    fire("swipeleft", {
                        dx,
                        dy,
                        elapsed,
                        velocityX
                    });
                } else if (dx >= useTh) {
                    fire("swiperight", {
                        dx,
                        dy,
                        elapsed,
                        velocityX
                    });
                }
            }

            dx = 0;
            dy = 0;
            lockedAxis = null;
        };

        // Pointer Events (preferred)
        container.addEventListener("pointerdown", onDown, {
            passive: true
        });
        container.addEventListener("pointermove", onMove, {
            passive: false
        });
        container.addEventListener("pointerup", onUp, {
            passive: true
        });
        container.addEventListener("pointercancel", onUp, {
            passive: true
        });
        container.addEventListener("pointerleave", onUp, {
            passive: true
        });

        // Touch fallback (older browsers)
        container.addEventListener("touchstart", onDown, {
            passive: true
        });
        container.addEventListener("touchmove", onMove, {
            passive: false
        });
        container.addEventListener("touchend", onUp, {
            passive: true
        });
        container.addEventListener("touchcancel", onUp, {
            passive: true
        });

        // Detach
        return function detach() {
            container.removeEventListener("pointerdown", onDown);
            container.removeEventListener("pointermove", onMove);
            container.removeEventListener("pointerup", onUp);
            container.removeEventListener("pointercancel", onUp);
            container.removeEventListener("pointerleave", onUp);

            container.removeEventListener("touchstart", onDown);
            container.removeEventListener("touchmove", onMove);
            container.removeEventListener("touchend", onUp);
            container.removeEventListener("touchcancel", onUp);
        };
    }

    // -----------------------------
    // Bootstrapping
    // -----------------------------
    document.addEventListener("DOMContentLoaded", () => {
        // Initial render
        init(currentSlide);

        // Next button
        const btnNext = document.getElementById("next");
        if (btnNext) btnNext.addEventListener("click", next);
        const btnEnd = document.getElementById("end");
        if (btnEnd) btnEnd.addEventListener("click", showLogin);

        // Dots (optional click jump)
        // dots.forEach((dot, i) => {
        //   dot.addEventListener("click", () => {
        //     currentSlide = i;
        //     init(currentSlide);
        //   });
        // });

        // Swipe bindings
        const detachSwipe = createSwipeRecognizer(sliderEl, {
            threshold: 48,
            fastMs: 450,
            fastThreshold: 24,
        });

        sliderEl?.addEventListener("swipeleft", () => next());
        sliderEl?.addEventListener("swiperight", () => prev());

        // If you ever need to clean up: call detachSwipe();
    });
</script>
