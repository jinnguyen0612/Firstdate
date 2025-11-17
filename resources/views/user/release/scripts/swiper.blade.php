<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper(".mySwiper", {
            allowTouchMove: false,
            mousewheel: false,
            keyboard: {
                enabled: false
            },
            slidesPerView: "auto",
            spaceBetween: 30,
            pagination: {
                el: ".swiper-pagination",
                type: "progressbar"
            },
            navigation: {
                nextEl: ".button-next",
                prevEl: ".button-prev"
            },
            observer: true,
            observeParents: true,
            updateOnWindowResize: true
        });

        // ===== Nav visibility =====
        const nextBtnContainer = document.querySelector('.button-next-container');
        const prevBtn = document.querySelector('.button-prev');
        const closeBtn = document.querySelector('.button-close');
        const swiperContainer = document.querySelector('.swiper-container');

        // LẤY TẤT CẢ các khối .label-info (label + 2 btn)
        const infoBoxes = document.querySelectorAll('.label-info');

        function setInfoVisible(show) {
            infoBoxes.forEach(el => {
                el.style.display = show ? '' : 'none';
            });
        }

        function updateNavVisibility() {
            if (nextBtnContainer) nextBtnContainer.style.display = swiper.isEnd ? 'none' : '';
            if (prevBtn) prevBtn.style.display = swiper.isBeginning ? 'none' : '';
            if (closeBtn) closeBtn.style.display = swiper.isBeginning ? '' : 'none';

            // Hiện/ẩn toàn bộ .label-info khi tới slide cuối
            setInfoVisible(swiper.isEnd);

            // Đổi chiều cao container và update Swiper
            if (swiperContainer) {
                const endClass = 'swiper-end-height';
                const normalClass = 'swiper-normal-height';

                const newClass = swiper.isEnd ? endClass : normalClass;
                const oldClass = swiper.isEnd ? normalClass : endClass;

                if (!swiperContainer.classList.contains(newClass)) {
                    swiperContainer.classList.remove(oldClass);
                    swiperContainer.classList.add(newClass);

                    requestAnimationFrame(() => {
                        swiper.update();
                        requestAnimationFrame(() => swiper.update());
                    });
                }
            }

        }

        swiper.on('afterInit', updateNavVisibility);
        swiper.on('slideChange', updateNavVisibility);
        swiper.on('update', updateNavVisibility);
        swiper.on('resize', updateNavVisibility);
        if (swiper.initialized) updateNavVisibility();

        // ===== Progress knob (robust) =====
        function setupKnob() {
            const pagRoot = swiper.pagination?.el || swiper.el.querySelector('.swiper-pagination');
            if (!pagRoot) return;

            function getTrack() {
                return pagRoot.querySelector('.swiper-pagination-progressbar') || pagRoot;
            }

            function ensureKnob() {
                const track = getTrack();
                if (!track) return null;
                let knob = track.querySelector('.progress-knob');
                if (!knob) {
                    knob = document.createElement('div');
                    knob.className = 'progress-knob';
                    // Inline style tối thiểu (bỏ nếu đã có CSS riêng)
                    knob.style.position = 'absolute';
                    knob.style.top = '50%';
                    knob.style.left = '0';
                    knob.style.width = '18px';
                    knob.style.height = '18px';
                    knob.style.borderRadius = '50%';
                    knob.style.transform = 'translate(0, -50%)';
                    knob.style.pointerEvents = 'none';
                    knob.style.zIndex = '2';
                    const cs = getComputedStyle(track).position;
                    if (!cs || cs === 'static') track.style.position = 'relative';
                    track.appendChild(knob);
                }
                return knob;
            }

            const clamp01 = v => Math.max(0, Math.min(1, v));
            const stepsCount = () => {
                const snaps = swiper.snapGrid?.length || 0;
                if (snaps > 1) return snaps - 1;
                const slides = swiper.slides?.length || 1;
                return Math.max(1, slides - 1);
            };
            const trueProgress = () => {
                const min = swiper.minTranslate();
                const max = swiper.maxTranslate();
                const t = swiper.translate;
                if (max === min) return 0;
                return clamp01((t - min) / (max - min));
            };
            const snapProgress = () => {
                const steps = stepsCount();
                const idx = (swiper.snapIndex ?? swiper.activeIndex ?? 0);
                return clamp01(idx / steps);
            };
            const addOneTick = (p) => {
                const steps = stepsCount();
                return clamp01((p * steps + 1) / (steps + 1));
            };

            function setByProgress(pOffset) {
                const track = getTrack();
                const knob = ensureKnob();
                if (!track || !knob) return;
                const trackW = track.clientWidth || 0;
                const knobW = knob.offsetWidth || 0;
                const travel = Math.max(0, trackW - knobW);
                const isRTL = !!swiper.rtlTranslate;
                const prog = isRTL ? (1 - clamp01(pOffset)) : clamp01(pOffset);
                const x = prog * travel;
                knob.style.transform = `translate3d(${x}px, -50%, 0)`;
            }

            const attachEnsure = () => {
                ensureKnob();
                setByProgress(addOneTick(snapProgress()));
            };

            swiper.on('afterInit', attachEnsure);
            swiper.on('paginationUpdate', attachEnsure);
            swiper.on('update', attachEnsure);
            swiper.on('resize', attachEnsure);
            swiper.on('observerUpdate', attachEnsure);

            swiper.on('progress', () => {
                const knob = ensureKnob();
                if (knob) knob.style.transitionDuration = '0ms';
                setByProgress(addOneTick(trueProgress()));
            });

            swiper.on('setTransition', (_, speed) => {
                const knob = ensureKnob();
                if (!knob) return;
                knob.style.transitionProperty = 'transform';
                knob.style.transitionDuration = `${speed}ms`;
            });

            swiper.on('slideChange', () => setByProgress(addOneTick(snapProgress())));

            if (swiper.initialized) attachEnsure();

            const mo = new MutationObserver(() => attachEnsure());
            mo.observe(pagRoot, {
                childList: true,
                subtree: true
            });
        }

        if (swiper.pagination && swiper.pagination.el) setupKnob();
        else swiper.on('afterInit', setupKnob);

        // ===== Submit buttons (chung class, khác data-subsidy) =====
        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('.btnSubmitRegister');
            if (!btn) return;
            const subsidy = Number(btn.getAttribute('data-subsidy') || '0');
            // TODO: gọi API/submit theo subsidy
            console.log('Submit with subsidy:', subsidy);
        });
    });
</script>
