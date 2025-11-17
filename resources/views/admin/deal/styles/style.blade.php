<style>
    .swiper-container-wrapper {
        position: relative;
    }

    .swiper-container-wrapper--timeline .swiper-slide {
        background: #fff;
        min-height: 300px;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    .swiper-container-wrapper--timeline .swiper-slide .container {
        padding: 0;
        width: 100%;
    }

    .swiper-container-wrapper--timeline .swiper-slide .title {
        font-size: 18px;
        opacity: 0;
        transition: 0.5s ease 0.5s;
    }

    .swiper-container-wrapper--timeline .swiper-slide-active .title {
        opacity: 1;
    }

    /* Progress bar */
    .swiper-container-wrapper--timeline .swiper-pagination-progressbar {
        position: absolute;
        top: 18%;
        background-color: transparent;
        height: 4px;
        border-bottom: 1px solid #888;
        width: 100%;
        /* Bám theo card */
        max-width: 100%;
    }

    .swiper-container-wrapper--timeline .swiper-pagination-progressbar-fill {
        background-color: #000;
        height: 3px;
        top: 2px;
    }

    /* Loại bỏ tràn không cần thiết */
    .swiper-container-wrapper--timeline .swiper-pagination-progressbar:before,
    .swiper-container-wrapper--timeline .swiper-pagination-progressbar:after {
        left: 0;
        right: 0;
        content: "";
    }

    /* Custom pagination */
    .swiper-container-wrapper--timeline .swiper-pagination-custom {
        position: relative;
        list-style: none;
        margin: 1rem auto;
        padding: 0;
        display: flex;
        justify-content: space-between;
        line-height: 1.66;
        bottom: 0;
        z-index: 11;
        width: 100%;
    }

    .swiper-container-wrapper--timeline .swiper-pagination-custom .swiper-pagination-switch {
        position: relative;
        flex: 1;
        text-align: center;
        height: 30px;
        line-height: 30px;
    }

    .swiper-container-wrapper--timeline .swiper-pagination-custom .swiper-pagination-switch .switch-title {
        position: relative;
        font-weight: 400;
        transition: 0.2s all ease-in-out;
        cursor: pointer;
        z-index: 1;
    }

    .swiper-container-wrapper--timeline .swiper-pagination-custom .swiper-pagination-switch .switch-title:after {
        content: "";
        position: absolute;
        top: calc(100% + 8px);
        left: 50%;
        transform: translateX(-50%) translateY(75%);
        width: 12px;
        height: 12px;
        background: #000;
        border-radius: 50%;
        transition: 0.2s all ease-in-out;
        z-index: 1;
    }

    .swiper-container-wrapper--timeline .swiper-pagination-custom .swiper-pagination-switch.active .switch-title:after {
        background: #000;
        transform: translateX(-50%) translateY(25%);
        width: 20px;
        height: 20px;
        transition-delay: 0.4s;
    }

    .swiper-container-wrapper--timeline .swiper-pagination-custom .swiper-pagination-switch.active~.swiper-pagination-switch .switch-title {
        color: #888;
        font-weight: normal;
    }

    .swiper-container-wrapper--timeline .swiper-pagination-custom .swiper-pagination-switch.active~.swiper-pagination-switch i {
        color: #888;
        font-weight: normal;
    }

    .swiper-container-wrapper--timeline .swiper-pagination-custom .swiper-pagination-switch.active~.swiper-pagination-switch .switch-title:after {
        background: #888;
    }

    .swiper-container-wrapper--timeline .swiper-pagination-custom .swiper-pagination-switch.active~.swiper-pagination-switch i:after {
        background: #888;
    }

    /* Disabled state */
    .swiper-pagination-switch.disabled {
        pointer-events: none;
        opacity: 0.4;
        cursor: not-allowed;
    }

    /* Mặc định: hiện chữ */
    .title-can-hide {
        display: inline-block;
    }

    .swiper-pagination-switch>i {
        font-size: 1rem;
    }

    .district-card {
        display: block;
    }

    .district-card input:checked~.district-card-body {
        border: 1px solid #2fb344;
        border-radius: 12px;
        padding: 1rem;
        background-color: #2fb344;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
        transition: 0.2s;
        color: #fff;
        opacity: 0.6;
    }

    .district-card input:checked~.district-card-body i {
        font-size: 1.25rem;
        color: #fff;
    }

    .district-card-body {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1rem;
        background-color: #f9f9f9;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
        transition: 0.2s;
        color: #000000;
        opacity: 0.6;
    }

    .district-card-body i {
        font-size: 1.25rem;
        color: #000000;
    }


    /* Trên mobile: ẩn chữ */
    @media (max-width: 767.98px) {
        .title-can-hide {
            display: none;
        }

        .swiper-pagination-switch>i {
            font-size: 2rem;
        }
    }
</style>
