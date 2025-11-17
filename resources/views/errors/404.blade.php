<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link rel="stylesheet" href="{{ asset('public/user/assets/bootstrap-5.3.3-dist/css/bootstrap.min.css') }}">

    @if ((auth('admin')->user() && auth('admin')->user()->hasRole('superAdmin')) || auth('web')->user())
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Arial', sans-serif;
                background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                position: relative;
            }

            .stars {
                position: absolute;
                width: 100%;
                height: 100%;
                pointer-events: none;
            }

            .star {
                position: absolute;
                background: white;
                border-radius: 50%;
                animation: twinkle 1s infinite;
            }

            @keyframes twinkle {

                0%,
                100% {
                    opacity: 0.3;
                }

                50% {
                    opacity: 1;
                }
            }

            .container {
                text-align: center;
                padding: 2rem;
                max-width: 600px;
                z-index: 1;
            }

            .title {
                font-size: 8rem;
                font-weight: bold;
                background: linear-gradient(45deg, #6b3de0 0%, #9c44dc 50%, #6b3de0 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-size: 200% auto;
                animation: shine 2s linear infinite;
                margin-bottom: 1rem;
                text-shadow: 0 0 10px rgba(156, 68, 220, 0.3);
            }

            @keyframes shine {
                to {
                    background-position: 200% center;
                }
            }

            .subtitle {
                color: #fff;
                font-size: 1.5rem;
                margin-bottom: 2rem;
                opacity: 0.8;
            }

            .message {
                color: #ccc;
                font-size: 1rem;
                margin-bottom: 2rem;
                line-height: 1.6;
            }

            .button {
                display: inline-block;
                padding: 1rem 2rem;
                background: linear-gradient(45deg, #6b3de0, #9c44dc);
                color: white;
                text-decoration: none;
                border-radius: 50px;
                font-weight: bold;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border: none;
                cursor: pointer;
            }

            .button:hover {
                transform: translateY(-3px);
                box-shadow: 0 5px 15px rgba(107, 61, 224, 0.4);
            }

            @media (max-width: 768px) {
                .title {
                    font-size: 5rem;
                }

                .subtitle {
                    font-size: 1.2rem;
                }

                .message {
                    font-size: 0.9rem;
                }

                .button {
                    padding: 0.8rem 1.6rem;
                }
            }

            @media (max-width: 480px) {
                .title {
                    font-size: 3rem;
                }

                .container {
                    padding: 1rem;
                }
            }
        </style>
    @endif
    @if (auth('partner')->user() || (auth('admin')->user() && auth('admin')->user()->hasRole('subAdmin')))
        <style>
            @import url('https://fonts.googleapis.com/css?family=Fira+Sans');

            * {
                box-sizing: border-box;
            }

            html,
            body {
                margin: 0;
                padding: 0;
            }

            body {
                font-family: "Fira Sans", sans-serif;
                color: #f5f6fa;
            }

            .background {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(#0C0E10, #446182);
            }

            .background .ground {
                position: absolute;
                bottom: 0;
                width: 100%;
                height: 25vh;
                background: #0C0E10;
            }

            @media (max-width: 770px) {
                .background .ground {
                    height: 0vh;
                }
            }

            .container {
                position: relative;
                margin: 0 auto;
                width: 85%;
                height: 100vh;
                padding-bottom: 25vh;
                display: flex;
                flex-direction: row;
                justify-content: space-around;
            }

            @media (max-width: 770px) {
                .container {
                    flex-direction: column;
                    padding-bottom: 0vh;
                }
            }

            .left-section,
            .right-section {
                position: relative;
            }

            /* Left Section */
            .left-section {
                width: 40%;
            }

            @media (max-width: 770px) {
                .left-section {
                    width: 100%;
                    height: 40%;
                    position: absolute;
                    top: 0;
                }
            }

            .left-section .inner-content {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
            }

            @media (max-width: 770px) {
                .left-section .inner-content {
                    position: relative;
                    padding: 1rem 0;
                }
            }

            .heading {
                text-align: center;
                font-size: 9em;
                line-height: 1.3em;
                margin: 2rem 0 0.5rem 0;
                padding: 0;
                text-shadow: 0 0 1rem #fefefe;
            }

            @media (max-width: 770px) {
                .heading {
                    font-size: 7em;
                    line-height: 1.15;
                    margin: 0;
                }
            }

            .subheading {
                text-align: center;
                max-width: 480px;
                font-size: 1.5em;
                line-height: 1.15em;
                padding: 0 1rem;
                margin: 0 auto;
            }

            @media (max-width: 770px) {
                .subheading {
                    font-size: 1.3em;
                    line-height: 1.15;
                    max-width: 100%;
                }
            }

            /* Right Section */
            .right-section {
                width: 50%;
            }

            @media (max-width: 770px) {
                .right-section {
                    width: 100%;
                    height: 60%;
                    position: absolute;
                    bottom: 0;
                }
            }

            .svgimg {
                position: absolute;
                bottom: 0;
                padding-top: 10vh;
                padding-left: 1vh;
                max-width: 100%;
                max-height: 100%;
            }

            @media (max-width: 770px) {
                .svgimg {
                    padding: 0;
                }
            }

            .svgimg .bench-legs {
                fill: #0C0E10;
            }

            .svgimg .top-bench,
            .svgimg .bottom-bench {
                stroke: #0C0E10;
                stroke-width: 1px;
                fill: #5B3E2B;
            }

            .svgimg .bottom-bench path:nth-child(1) {
                fill: #4e3326;
            }

            .svgimg .lamp-details {
                fill: #202425;
            }

            .svgimg .lamp-accent {
                fill: #2a2e2f;
            }

            .svgimg .lamp-bottom {
                fill: linear-gradient(#202425, #0C0E10);
            }

            .svgimg .lamp-light {
                fill: #EFEFEF;
            }

            @keyframes glow {
                0% {
                    text-shadow: 0 0 1rem #fefefe;
                }

                50% {
                    text-shadow: 0 0 1.85rem #ededed;
                }

                100% {
                    text-shadow: 0 0 1rem #fefefe;
                }
            }
        </style>
    @endif
    @if (!(auth('admin')->user() || auth('web')->user() || auth('partner')->user()))
        <style>
            .error-container {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background-color: #f8f9fa;
            }

            .error-content {
                text-align: center;
            }

            .error-content h1 {
                font-size: 6rem;
                font-weight: bold;
                margin-bottom: 1rem;
            }

            .error-content p {
                font-size: 1.5rem;
                margin-bottom: 2rem;
            }

            .lottie-animation {
                max-width: 400px;
                margin-bottom: 2rem;
            }
        </style>
    @endif
</head>

<body>
    @if ((auth('admin')->user() && auth('admin')->user()->hasRole('superAdmin')) || auth('web')->user())
        <div class="stars"></div>
        <div class="container">
            <h1 class="title">Oops!</h1>
            <h2 class="subtitle">404 - Page Not Found</h2>
            <p class="message">The page you are looking for might have been removed, had its name changed, or is
                temporarily unavailable.</p>
            <a href="{{ Route::has('user.index') ? route('user.index') : route('admin.dashboard') }}" class="button">GO
                TO HOMEPAGE</a>
        </div>

        <script>
            // Create stars
            function createStars() {
                const stars = document.querySelector('.stars');
                const numStars = 200;

                for (let i = 0; i < numStars; i++) {
                    const star = document.createElement('div');
                    star.className = 'star';

                    // Random position
                    const x = Math.random() * 100;
                    const y = Math.random() * 100;

                    // Random size
                    const size = Math.random() * 3;

                    star.style.left = `${x}%`;
                    star.style.top = `${y}%`;
                    star.style.width = `${size}px`;
                    star.style.height = `${size}px`;

                    // Random animation delay
                    star.style.animationDelay = `${Math.random() * 1}s`;

                    stars.appendChild(star);
                }
            }

            createStars();
        </script>
    @endif
    @if (auth('partner')->user() || (auth('admin')->user() && auth('admin')->user()->hasRole('subAdmin')))
        <div class="background">
            <div class="ground"></div>
        </div>
        <div class="container">
            <div class="left-section">
                <div class="inner-content">
                    <h1 class="heading">404</h1>
                    <p class="subheading">Đường dẫn đang truy cập đến không tồn tại.</p>
                    <div class="text-center mt-4">
                        <a href="{{ route('partner.home.index') }}" class="btn btn-primary">Trở về trang chủ</a>
                    </div>
                </div>
            </div>
            <div class="right-section">
                <svg class="svgimg" xmlns="http://www.w3.org/2000/svg" viewBox="51.5 -15.288 385 505.565">
                    <g class="bench-legs">
                        <path d="M202.778,391.666h11.111v98.611h-11.111V391.666z M370.833,390.277h11.111v100h-11.111V390.277z M183.333,456.944h11.111
          v33.333h-11.111V456.944z M393.056,456.944h11.111v33.333h-11.111V456.944z" />
                    </g>
                    <g class="top-bench">
                        <path
                            d="M396.527,397.917c0,1.534-1.243,2.777-2.777,2.777H190.972c-1.534,0-2.778-1.243-2.778-2.777v-8.333
          c0-1.535,1.244-2.778,2.778-2.778H393.75c1.534,0,2.777,1.243,2.777,2.778V397.917z M400.694,414.583
          c0,1.534-1.243,2.778-2.777,2.778H188.194c-1.534,0-2.778-1.244-2.778-2.778v-8.333c0-1.534,1.244-2.777,2.778-2.777h209.723
          c1.534,0,2.777,1.243,2.777,2.777V414.583z M403.473,431.25c0,1.534-1.244,2.777-2.778,2.777H184.028
          c-1.534,0-2.778-1.243-2.778-2.777v-8.333c0-1.534,1.244-2.778,2.778-2.778h216.667c1.534,0,2.778,1.244,2.778,2.778V431.25z" />
                    </g>
                    <g class="bottom-bench">
                        <path d="M417.361,459.027c0,0.769-1.244,1.39-2.778,1.39H170.139c-1.533,0-2.777-0.621-2.777-1.39v-4.86
          c0-0.769,1.244-0.694,2.777-0.694h244.444c1.534,0,2.778-0.074,2.778,0.694V459.027z" />
                        <path
                            d="M185.417,443.75H400c0,0,18.143,9.721,17.361,10.417l-250-0.696C167.303,451.65,185.417,443.75,185.417,443.75z" />
                    </g>
                    <g id="lamp">
                        <path class="lamp-details" d="M125.694,421.997c0,1.257-0.73,3.697-1.633,3.697H113.44c-0.903,0-1.633-2.44-1.633-3.697V84.917
          c0-1.257,0.73-2.278,1.633-2.278h10.621c0.903,0,1.633,1.02,1.633,2.278V421.997z" />
                        <path class="lamp-accent" d="M128.472,93.75c0,1.534-1.244,2.778-2.778,2.778h-13.889c-1.534,0-2.778-1.244-2.778-2.778V79.861
          c0-1.534,1.244-2.778,2.778-2.778h13.889c1.534,0,2.778,1.244,2.778,2.778V93.75z" />

                        <circle class="lamp-light" cx="119.676" cy="44.22" r="40.51" />
                        <path class="lamp-details" d="M149.306,71.528c0,3.242-13.37,13.889-29.861,13.889S89.583,75.232,89.583,71.528c0-4.166,13.369-13.889,29.861-13.889
          S149.306,67.362,149.306,71.528z" />
                        <radialGradient class="light-gradient" id="SVGID_1_" cx="119.676" cy="44.22" r="65"
                            gradientUnits="userSpaceOnUse">
                            <stop offset="0%" style="stop-color:#FFFFFF; stop-opacity: 1" />
                            <stop offset="50%" style="stop-color:#EDEDED; stop-opacity: 0.5">
                                <animate attributeName="stop-opacity" values="0.0; 0.5; 0.0" dur="5000ms"
                                    repeatCount="indefinite"></animate>
                            </stop>
                            <stop offset="100%" style="stop-color:#EDEDED; stop-opacity: 0" />
                        </radialGradient>
                        <circle class="lamp-light__glow" fill="url(#SVGID_1_)" cx="119.676" cy="44.22" r="65" />
                        <path class="lamp-bottom" d="M135.417,487.781c0,1.378-1.244,2.496-2.778,2.496H106.25c-1.534,0-2.778-1.118-2.778-2.496v-74.869
          c0-1.378,1.244-2.495,2.778-2.495h26.389c1.534,0,2.778,1.117,2.778,2.495V487.781z" />
                    </g>
                </svg>
            </div>
        </div>
    @endif
    @if (!(auth('admin')->user() || auth('web')->user() || auth('partner')->user()))
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.6/lottie.min.js"></script>

        <div class="error-container">
            <div class="lottie-animation"></div>
            <div class="error-content">
                <h1>Error!</h1>
                <p>Oops! Product Not Found :(</p>
            </div>
        </div>
        <script>
            const animation = lottie.loadAnimation({
                container: document.querySelector('.lottie-animation'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: 'https://lottie.host/d987597c-7676-4424-8817-7fca6dc1a33e/BVrFXsaeui.json'
            });
        </script>
    @endif
</body>

</html>
