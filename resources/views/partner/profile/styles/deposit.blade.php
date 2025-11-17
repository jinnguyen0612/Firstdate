<style>
    /* Image input */
    .image-input {
        text-align: center;
    }

    .image-input input {
        display: none;
    }

    .image-input label {
        display: block;
        color: #FFF;
        background: #000;
        padding: .3rem .6rem;
        font-size: 115%;
        cursor: pointer;
    }

    .image-input label i {
        font-size: 125%;
        margin-right: .3rem;
    }

    .image-input label:hover i {
        animation: shake .35s;
    }

    .image-input img {
        max-width: 175px;
        display: none;
    }

    .image-input span {
        display: none;
        text-align: center;
        cursor: pointer;
    }

    .btnComplete {
        width: 100%;
    }

    /* animation keyframes */
    @keyframes shake {
        0% {
            transform: rotate(0deg);
        }

        25% {
            transform: rotate(10deg);
        }

        50% {
            transform: rotate(0deg);
        }

        75% {
            transform: rotate(-10deg);
        }

        100% {
            transform: rotate(0deg);
        }
    }
</style>
