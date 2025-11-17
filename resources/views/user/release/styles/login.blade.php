<style>
    .button-prev:focus-visible,
    .button-next:focus-visible {
        outline: none;
    }

    .form-control:focus-visible,
    .form-control:focus {
        outline: none;
        border: 1px solid hsla(210, 11%, 15%, 0.1);
    }

    #user-info,
    #info,
    #verify,
    #sendOtp {
        padding: 5% 12px;
    }

    .swiper-normal-height {
        height: 75vh;
    }


    .swiper-end-height {
        height: 70vh;
    }

    @media (min-width: 577px) and (max-width: 768px) {
        .swiper-end-height {
            height: 65vh;
        }
    }


    @media (max-width: 576px) {
        .swiper-end-height {
            height: 60vh;
        }
    }

    #sendOtp .phone-input {
        padding: 5px 5%;
    }

    #user-info .btn-group,
    #info .btn-group {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #verify .btn-group,
    #sendOtp .btn-group {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px 5%;
    }

    #user-info .btn-group .btn,
    #info .btn-group .btn,
    #verify .btn-group .btn,
    #sendOtp .btn-group .btn {
        flex: 1;
        width: 100%;
    }

    .scroll-y {
        overflow-y: auto;
    }

    .scroll-x {
        overflow-x: auto;
    }

    .scroll-y::-webkit-scrollbar-track,
    .scroll-x::-webkit-scrollbar-track {
        background: transparent;
    }

    .scroll-y::-webkit-scrollbar,
    .scroll-x::-webkit-scrollbar {
        display: none;
    }

    .btn.text-default:active {
        border: none;
    }

    .btn.text-default:hover,
    .btn.text-default:focus-visible {
        color: hsla(0, 90%, 60%, 0.75);
    }

    .sendOtp-title {
        margin-bottom: 20px;
    }

    .phone-input,
    .btn-group {
        width: 100%;
        max-width: 500px;
    }
</style>
