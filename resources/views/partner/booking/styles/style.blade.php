<style>
    .title {
        font-weight: 500;
        font-size: 1.2rem;
        padding: 0.5rem 0;
        width: 80vw;
    }

    .bg-cancel {
        background-color: rgba(128, 128, 128, 0.342);
    }

    .booking-code-container {
        justify-content: space-between;
        font-weight: 400;
        font-size: 1.1rem;
        padding: 0 10px;
    }

    .booking-time-container {
        font-size: 1.1rem;
    }

    .btn-copy {
        cursor: pointer;
        color: white;
        padding: 2px 5px;
    }

    .btn-copy:hover,
    .btn.btn-copy:active {
        color: white;
    }

    .time-field {
        text-align: center;
        height: 100px;
        width: 100px;
        border-radius: 5px;
        border: 1px solid var(--tblr-border-color);
        font-size: 1.4rem;
        font-weight: 500;
        background-color: rgb(233, 233, 233);
    }

    .time-field:focus {
        border: 1px solid var(--tblr-primary);
        box-shadow: 0 0 0 0.15rem rgba(var(--tblr-primary-rgb), 0.15);
    }

    .user-card {
        border: none;
    }

    .image-container {
        position: relative;
    }

    .user-age {
        position: absolute;
        bottom: 5px;
        right: 5px;
        color: #fff;
        font-size: 1rem;
        font-weight: 500;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .user-cancel {
        position: absolute;
        top: 5px;
        left: 5px;
        color: #fff;
        font-size: .8rem;
        font-weight: 500;
        background-color: rgba(245, 62, 62, 0.7);
    }

    .btn-reject {
        background-color: rgb(236, 236, 236);
        color: #F53E3E;
    }

    .btn-reject:hover {
        background-color: rgb(218, 218, 218);
        color: #F53E3E;
    }

    .btn-default:hover {
        background-color: #cc0c0c;
    }

    .btn-container {
        position: fixed;
        bottom: 0;
        background-color: #fff;
        padding: 10px 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        width: 100%;
        box-shadow: -1px -4px 5px 0px rgba(172, 172, 172, 0.603);
    }

    .btn-action {
        margin: 5px 0;
    }

    .btn-container .btn {
        font-size: 1.2rem;
        font-weight: 400;
        width: 90%;
    }

    span.avatar {
        width: 60px;
        height: 60px;
        content: '';
        display: inline-block;
        background-size: cover;
        background-position: center center;
        border-radius: 10px;
    }

    .name {
        font-size: 1.1rem;
        font-weight: 500;
    }

    .age {
        font-size: 0.9rem;
        font-weight: 400;
    }

    .round {
        position: relative;
    }

    .round label {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 6px;
        cursor: pointer;
        height: 28px;
        right: 0;
        position: absolute;
        top: 8px;
        width: 28px;
    }

    .round label:after {
        border: 2px solid #fff;
        border-top: none;
        border-right: none;
        content: "";
        height: 6px;
        left: 7px;
        opacity: 0;
        position: absolute;
        top: 8px;
        transform: rotate(-45deg);
        width: 12px;
    }

    .round input[type="checkbox"] {
        visibility: hidden;
    }

    .round input[type="checkbox"]:checked+label {
        background-color: #2195d8;
        border-color: #1d91d4;
    }

    .round input[type="checkbox"]:checked+label:after {
        opacity: 1;
    }

    .invoice-image {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 10px;
    }

    .invoice-image img {
        min-width: 250px;
        height: auto;
        max-width: 400px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 10px;

    }


    [type="radio"]:checked,
    [type="radio"]:not(:checked) {
        position: absolute;
        left: -9999px;
    }

    [type="radio"]:checked+label,
    [type="radio"]:not(:checked)+label {
        position: relative;
        padding-left: 28px;
        cursor: pointer;
        line-height: 20px;
        display: inline-block;
        color: #000000;
    }

    [type="radio"]:checked+label:before,
    [type="radio"]:not(:checked)+label:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 18px;
        height: 18px;
        border: 1px solid #ddd;
        border-radius: 100%;
        background: #fff;
    }

    [type="radio"]:checked+label:after,
    [type="radio"]:not(:checked)+label:after {
        content: '';
        width: 12px;
        height: 12px;
        background: #F53E3E;
        position: absolute;
        top: 3px;
        left: 3px;
        border-radius: 100%;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
    }

    [type="radio"]:not(:checked)+label:after {
        opacity: 0;
        -webkit-transform: scale(0);
        transform: scale(0);
    }

    [type="radio"]:checked+label:after {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
    }

    @media (min-width: 1023px) {
        .title {
            width: 40vw;
        }

        .time-title {
            text-align: center;
        }

        .booking-code-container {
            justify-content: flex-start;
        }

        .btn-container {
            flex-direction: row;
            justify-content: space-around;
        }

        .btn-container .btn {
            width: 30vw;
        }

        .btn-container .single-btn .btn {
            width: 80vw;
        }
    }
</style>
