<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partner.layouts.head')
</head>

<body>
    <div id="root">
        <div id="header" class="container-fluid p-0">
            <x-header />
        </div>
        @yield('content')
        
        <div id="image-modal">
            <img src="" alt="Full Image">
        </div>

    </div>
    @include('partner.layouts.modal.modal-logout')
    @include('partner.scripts.scripts')
    <x-alert />
</body>

</html>
