<style>
    @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap");

    * {
        margin: 0;
        padding: 0;
    }

    body {
        background: #ecf2fe;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        justify-content: center;
        align-items: center;
        font-family: "Roboto", sans-serif;
    }

    .account-avatar {
        width: 32px;
        height: 32px;
        display: inline-block;
        content: '';
        border-radius: 50%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    .container .app-name {
        display: flex;
        font-size: 30px;
        font-weight: 700;
        color: #216fe0;
        margin-bottom: 10px;
        text-align: center;
        justify-content: center;
        align-items: center;
    }

    .container .app-name .logo {
        display: inline-block;
        width: 40px;
        height: 40px;
        background: url('{{ asset($settings->where('setting_key', 'favicon')->first()->plain_value) }}') no-repeat center;
        background-size: contain;
        margin-right: 10px;
        -webkit-transform: translateY(8%);
        -ms-transform: translateY(8%);
        transform: translateY(8%);
    }

    .container .table-name {
        display: block;
        font-size: 20px;
        font-weight: 500;
        color: #252f42;
        margin-bottom: 30px;
        text-align: center;
    }

    .container .booking-name {
        display: block;
        font-size: 20px;
        font-weight: 500;
        color: #252f42;
        text-align: center;
    }

    .container .title {
        font-size: 20px;
        font-weight: 500;
        -ms-flex-preferred-size: 100%;
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

    .app-icon {
        border: 1px solid #ddd;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
    }

    #otp .form-control {
        padding: .65rem .375rem
    }

    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999;
    }

    .modal-custom {
        background: #777777;
        padding: 2em;
        border-radius: 20px;
        width: 90%;
        max-width: 400px;
        text-align: center;
        position: relative;
        animation: popIn 0.4s ease forwards;
        transform: scale(0.8);
        opacity: 0;
    }

    @keyframes popIn {
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .modal-custom h2 {
        margin: 0 0 0.5em;
        font-size: 1.8em;
        color: #ff4081;
    }

    .modal-custom p {
        font-size: 1.1em;
        color: #ccc;
    }

    .modal-custom button.close-btn {
        margin-top: 1.5em;
        padding: 0.7em 1.5em;
        background: #ff4081;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        color: white;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .modal-custom button.close-btn:hover {
        background: #e73370;
        transform: translateY(-2px);
    }

    .glow-ring {
        position: absolute;
        width: 150%;
        height: 150%;
        border-radius: 50%;
        top: -25%;
        left: -25%;
        background: radial-gradient(circle, #ff408199 0%, transparent 70%);
        filter: blur(30px);
        z-index: -1;
        animation: pulse 2s infinite ease-in-out;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 0.6;
        }

        50% {
            transform: scale(1.1);
            opacity: 1;
        }
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

    /* inspiration */
    .inspiration {
        font-size: 12px;
        margin-top: 50px;
        position: absolute;
        bottom: 10px;
        font-weight: 300;
    }

    .inspiration a {
        color: #666;
    }

    @media screen and (max-width: 767px) {

        /* inspiration */
        .inspiration {
            display: none;
        }
    }
</style>
