<script>
    document.getElementById('timer').innerHTML =
        01 + ":" + 01;
    startTimer();


    function startTimer() {
        const timerDisplay = document.getElementById('timer');
        const resendOtp = document.getElementById('resend-otp');
        var presentTime = document.getElementById('timer').innerHTML;
        var timeArray = presentTime.split(/[:]+/);
        var m = timeArray[0];
        var s = checkSecond((timeArray[1] - 1));
        if (s == 59) {
            m = m - 1
        }
        if (m < 0) {
            timerDisplay.classList.add("d-none");
            resendOtp.classList.remove("d-none");
            return
        }

        document.getElementById('timer').innerHTML =
            m + ":" + s;

        setTimeout(startTimer, 1000);
    }

    function checkSecond(sec) {
        if (sec < 10 && sec >= 0) {
            sec = "0" + sec
        }; // add zero in front of numbers < 10
        if (sec < 0) {
            sec = "59"
        };
        return sec;
    }
</script>
