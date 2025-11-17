<style>
    #mainContent .modal {
        background-color: rgb(255, 176, 176) !important;
    }

    #welcome .image-container .img-fluid {
        width: 45vw;
    }

    #login {
        padding: 10vh 10vw;
    }

    .pageContent .container {
        padding: 2% 5%;
    }

    .slide-container .prev,
    .slide-container .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        margin-top: -22px;
        padding: 16px;
        color: white;
        font-weight: bold;
        font-size: 20px;
        transition: all 0.6s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
    }

    .slide-container .prev:hover,
    .slide-container .next:hover {
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
    }

    .slide-container .prev {
        left: 2px;
    }

    .slide-container .next {
        right: 2px;
    }

    .dots-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 5px;
    }

    .dots-container .dot {
        cursor: pointer;
        margin: 5px;
        width: 10px;
        height: 10px;
        color: #333;
        border-radius: 50%;
        background-color: #dfd6ce;
    }

    .dots-container .dot.active {
        border: 2px solid green;
    }

    .slide-container {
        display: flex;
        justify-content: center;
        align-items: center;
        max-width: 1000px;
        margin: auto;
        position: relative;
        overflow: hidden;
        /* Cho phép trang vẫn cuộn dọc tự nhiên, mình tự xử lý vuốt ngang */
        touch-action: pan-y;
        user-select: none;
    }

    .slide-container .slide {
        display: none;
        width: 100%;
    }

    .slide-container .slide.fade {
        animation: fade 0.5s cubic-bezier(0.55, 0.085, 0.68, 0.53) both;
    }

    .slide-container .slide img {
        width: 100%;
    }

    .slide-container .slide {
        height: 30vh;
        overflow: auto;
    }

    .pageContent .btn-group {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 5px 5%;
    }

    .pageContent .btn-group .btn {
        flex: 1;
        width: 100%;
    }

    .pageContent .btn-group .btn.btn-gray {
        background-color: #f2f2f2;
        color: #F53E3E;
    }

    .pageContent .btn-group .btn.btn-white {
        background-color: #f2f2f2;
        color: #F53E3E;
    }

    .bg-login {
        background-color: #ffb0b0;
    }

    .pageContent .content-group {
        padding: 2% 5%;
    }

    @media (min-width: 768px) and (max-width: 1023px) {
        #welcome .image-container .img-fluid {
            width: 20vw;
        }

        .slide-container .slide {
            height: 28vh;
        }
    }

    @media (min-width: 1024px){
        #welcome .image-container .img-fluid {
            width: 16vw;
        }

        .slide-container .slide {
            height: 24vh;
        }

        .welcome-title {
            text-align: center;
        }

        .fixed-bottom{
            margin-bottom: 5vh;
        }

        .btn-group{
            width: 50%;
            margin: auto;
        }
    }
</style>
