<style>
    .field-icon {
        position: absolute;
        right: 10px;
        top: 10px;
        cursor: pointer;
        color: #aaa;
    }

    .form-label {
        font-size: 1.1rem;
        font-weight: 450;
    }

    .group-input i {
        color: #F53E3E;
        font-size: 1.5rem;
    }

    .group-input {
        position: relative;
    }

    .group-input .s-icon,
    .group-input .s-icon::after,
    .group-input .s-icon::before {
        position: absolute;
        top: 3px;
        left: 5px;
        display: inline-block;
        align-items: center;
    }

    .group-input input {
        padding-left: 40px;
    }

    .otp-form .otp-container {
        border: 1px solid #aaa;
        display: inline-block;
        border-radius: 2px;
        width: 3rem;
        height: 3rem;
        padding: 5px;
        margin: 2px;
    }

    .otp-form .otp-field {
        display: inline-block;
        width: 1rem;
        height: 2rem;
        font-size: 1.5rem;
        line-height: 1.5rem;
        text-align: center;
        border: none;
        border-bottom: 2px solid var(--bs-secondary);
        outline: none;
    }

    .otp-form .otp-field:focus {
        border-bottom-color: var(--bs-dark);
    }

    @media (max-width: 375px) {

        .otp-form .otp-container {
            border: 1px solid #aaa;
            display: inline-block;
            border-radius: 2px;
            width: 2.2rem;
            height: 2.2rem;
            padding: 3px;
            margin: 2px;
        }

        .otp-form .otp-field {
            display: inline-block;
            width: 0.8rem;
            height: 1.6rem;
            font-size: 1.2rem;
            line-height: 1.2rem;
            text-align: center;
            border: none;
            border-bottom: 2px solid var(--bs-secondary);
            outline: none;
        }
    }

    @media (max-width: 350px) {
        .fs-sm-title {
            font-size: 1.2rem !important;
        }
        .fs-sm-text {
            font-size: 0.9rem !important;
        }
    }
</style>
