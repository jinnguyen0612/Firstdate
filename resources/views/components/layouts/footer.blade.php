<link rel="stylesheet" href="{{ asset('partner/assets/css/footer/footer.css') }}">



@php
    $currentUser = auth('partner')->user();
@endphp

<nav class="bottom-nav">

    <div class="indicator" id="bottom-nav-indicator"></div>
    <ul class="menu bottom-nav-menu">
        <li>
            <a href="#" class="active">
                <span class="icon">h</span>
                <span class="text">home</span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="icon">m</span>
                <span class="text">market</span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="icon">n</span>
                <span class="text">notifications</span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="icon">f</span>
                <span class="text">favourits</span>
            </a>
        </li>
    </ul>

</nav>

<!-- partial -->
<script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js'></script>

<script src="{{ asset('partner/assets/js/header/header.js') }}"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="{{ asset('partner/assets/js/footer/footer.js') }}"></script>
