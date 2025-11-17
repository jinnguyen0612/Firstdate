<style>
    .swiper-container {
        margin-bottom: 3%;
    }

    .swiper {
        width: 100%;
        height: 100%;
        padding-bottom: 12px;
    }

    .btn.btn-default.swiper-button-disabled:active,
    .btn.btn-default.swiper-button-disabled:focus,
    .btn.btn-default.swiper-button-disabled:focus-visible,
    .btn.btn-default.swiper-button-disabled {
        background-color: #F53E3E;
        color: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;
    }

    .swiper-slide {
        width: 100%;
    }

    /* Track */
    .swiper-horizontal>.swiper-pagination-progressbar,
    .swiper-pagination-progressbar.swiper-pagination-horizontal {
        top: inherit;
        bottom: 0;
        height: 4px;
    }

    /* Track cho phép tràn */
    .swiper-pagination-progressbar {
        --swiper-pagination-color: #ffb0b0;
        position: relative;
        overflow: visible;
        box-sizing: border-box;
    }

    .swiper-pagination-progressbar .progress-knob {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translate(0, -50%);
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: url('{{ asset('user/assets/release/svg/Logo-circle.svg') }}') no-repeat center;
        background-size: contain;
        pointer-events: none;
        will-change: transform;
        transition: transform 0ms linear;
        z-index: 2;
    }

    /* tuỳ chọn viền */
    .swiper-pagination-progressbar .progress-knob.has-ring {
        box-shadow:
            0 2px 6px rgba(0, 0, 0, .15),
            0 0 0 3px #0ea5e9 inset;
    }

    /* Form */
    .control-label {
        font-size: 1rem;
        margin-bottom: 5px;
    }

    .sub-label {
        font-size: 0.8rem;
        margin-top: 5px;
        color: hsla(0, 0%, 0%, 0.5);
    }

    #info input:focus,
    #info input:focus-visible {
        border: 1px solid rgba(0, 0, 0, 0.5);
        box-shadow: none;
    }

    /* Hide the default radio button */
    input[type="radio"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
        /* Prevents interaction with the hidden input directly */
    }

    /* Style the custom radio button appearance */
    input[type="radio"]+label {
        display: inline-block;
        padding-left: 20px;
        /* Space for the custom indicator */
        position: relative;
        cursor: pointer;
        line-height: 20px;
        /* Align text with indicator */
    }

    /* Create the custom radio button indicator */
    input[type="radio"]+label::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 18px;
        height: 18px;
        border: 2px solid #F53E3E;
        border-radius: 50%;
        background-color: #fff;
    }

    /* Style the indicator when the radio button is checked */
    input[type="radio"]:checked+label::before {
        background-color: #fff;
        /* Example: blue fill when checked */
        border-color: #F53E3E;
    }

    /* Add the inner dot for the checked state */
    input[type="radio"]:checked+label::after {
        content: '';
        position: absolute;
        left: 4px;
        top: 4px;
        width: 10px;
        height: 10px;
        background-color: #F53E3E;
        border-radius: 50%;
    }

    .image-input-container {
        width: 100%;
    }

    /* Ẩn input thật */
    #picture_input {
        display: none;
    }

    /* Khung preview: dùng aspect-ratio để tự tính chiều cao, KHÔNG set height tay */
    .picture {
        position: relative;
        width: min(100%, 400px);
        /* Tự tính chiều cao = chiều rộng */
        aspect-ratio: 10 / 10;
        height: auto;
        /* chỉnh tỉ lệ tùy ý */
        background: inherit;
        display: block;
        color: #888;
        cursor: pointer;
        border-radius: 8px;
        overflow: hidden;
        /* QUAN TRỌNG: chặn phần thừa */
    }

    .picture.border-custom {
        border: 2px dashed currentColor;
    }

    .picture:hover {
        color: #666;
    }

    .picture:focus {
        outline: none;
    }

    /* Lớp chứa preview phủ kín khung */
    .picture_image {
        position: absolute;
        inset: 0;
        display: grid;
        place-items: center;
        text-align: center;
        font: 500 clamp(14px, 2.3vw, 16px)/1.35 system-ui, sans-serif;
    }

    /* Ảnh fill đúng khung, không méo, không vượt quá .picture */
    .picture_img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    /* Trạng thái rỗng */
    .picture_image[data-empty="true"] {
        color: currentColor;
        opacity: .65;
    }

    /* Mobile: full chiều ngang, chiều cao tự tính theo aspect-ratio */
    @media (max-width:576px) {
        .picture {
            width: 90%;
        }
    }

    /* Group image */
    .image-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        width: 100%;
    }

    /* Card ô ảnh */
    .image-slot {
        position: relative;
        aspect-ratio: 3 / 4;
        /* giống hình minh hoạ */
        border: 2px dashed #c9c9c9;
        border-radius: 12px;
        background: #f3f3f3;
        cursor: pointer;
        overflow: hidden;
        display: grid;
        place-items: center;
        transition: border-color .15s ease, background .15s ease;
    }

    .image-slot:hover {
        border-color: #9aa0a6;
        background: #eee;
    }

    /* Dấu + mặc định */
    .image-slot .plus {
        font-size: 42px;
        line-height: 1;
        color: #8a8a8a;
        user-select: none;
        pointer-events: none;
    }

    /* Ảnh preview */
    .image-slot img.preview {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Nút xoá từng ô (tuỳ chọn) */
    .image-slot .remove {
        position: absolute;
        top: 6px;
        right: 6px;
        padding: 4px 8px;
        border-radius: 8px;
        background: rgba(0, 0, 0, .55);
        color: #fff;
        font-size: 12px;
        line-height: 1;
        border: none;
        cursor: pointer;
        display: none;
    }

    .image-slot.filled .remove {
        display: inline-block;
    }

    .input-age-find {
        position: relative;
    }

    .input-age-find .stick-label {
        position: absolute;
        font-size: 1rem;
        top: 50%;
        left: 3.5rem;
        transform: translateY(-50%);
    }

    .img-container .img-support {
        width: 60%;
        height: auto;
        max-width: 500px;
        max-height: 500px;
        object-fit: cover;
    }

    .title-support {
        font-size: 1.2rem;
    }

    #user-info .content-container {
        max-height: 22vh;
    }

    .content-support {
        font-size: 1rem;
    }

    .fixed-bottom {
        padding: 10px;
        margin-bottom: 10px;
        outline: none;
        overflow: hidden;
        box-shadow: none;
        border: none;
    }

    @media (min-width: 768px) and (max-width: 1023px) {
        .swiper-container {
            padding: 5% 5%;
        }

        #info {
            padding: 0 5%;
        }

        .image-grid {
            width: 50%;
        }
    }

    @media (min-width: 1024px) {
        .swiper-container {
            padding: 10px 5%;
        }

        .button-group-container {
            margin-bottom: 20px;
        }

        #info {
            padding: 0 5%;
        }

        .image-grid {
            width: 38%;
        }
    }
</style>
