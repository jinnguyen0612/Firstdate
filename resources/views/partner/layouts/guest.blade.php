<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partner.layouts.guest-head')
    <style>
        body {
            margin-top: 20px;
            margin-bottom: 20px;
            font-family: 'Roboto', sans-serif;
            
        }
    </style>
</head>

<body>
    <div id="root">
        @yield('content')

        <div id="image-modal">
            <img src="" alt="Full Image">
        </div>

    </div>
    @include('partner.scripts.scripts')
    <x-alert />
</body>

</html>
