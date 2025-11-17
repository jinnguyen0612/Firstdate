<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
@stack('meta')
<meta name="X-TOKEN" content="{{ csrf_token() }}">
<meta name="url-home" content="{{ url('/') }}">
<meta name="currency" content="{{ config('custom.currency') }}">
<meta name="position_currency" content="{{ config('custom.format.position_currency') }}">

{{-- Start: meta PWA --}}
<!-- Đặt PWA hiển thị toàn màn hình trên iOS -->
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="HoangGiaPS">
<link rel="manifest" href="{{ asset('pwa/manifest.json') }}">
<!-- Icon dành cho iOS -->
<link rel="apple-touch-icon" href="{{ asset($settings->where('setting_key', 'favicon')->first()->plain_value) }}">
{{-- End: meta PWA --}}

<title>@yield('title') - Đối tác FirstDate</title>
<link rel="icon" type="image/png"
    href="{{ asset($settings->where('setting_key', 'favicon')->first()->plain_value) }}" />
<!-- CSS files -->
<link href="{{ asset('public/libs/jquery-toast-plugin/jquery.toast.min.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('public/user/assets/bootstrap-5.3.3-dist/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/user/assets/css/index.css') }}">
<link rel="stylesheet" href="{{ asset('public/user/assets/tabler/plugins/tabler-icon/webfont/tabler-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/user/assets/css/content.css') }}">
<link rel="stylesheet" href="{{ asset('public/user/assets/css/category.css') }}">
<link rel="stylesheet" href="{{ asset('public/user/assets/css/container-sale-off.css') }}">
<link rel="stylesheet" href="{{ asset('public/user/assets/css/footer.css') }}">
<link rel="stylesheet" href="{{ asset('public/user/assets/css/product-category.css') }}">
<link rel="stylesheet" href="{{ asset('public/user/assets/css/container-categories-right-image.css') }}">
<link rel="stylesheet" href="{{ asset('public/user/assets/css/post.css') }}">
<link rel="stylesheet" href="{{ asset('public/libs/fontawesome6/css/all.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/user/assets/fotorama-4.6.4/fotorama.css') }}">

<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('/public/libs/datatables/plugins/bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('/public/libs/datatables/plugins/buttons/css/buttons.bootstrap5.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('/public/libs/datatables/plugins/responsive/css/responsive.bootstrap5.min.css') }}">

<link href="{{ asset('public/user/assets/css/index.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />


<style>
    /* Mặc định áp dụng cho màn hình lớn hơn 600px */

    body {
        margin-top: 80px;
        background: white;
        font-family: 'Roboto', sans-serif;
    }

    #image-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.8);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    #image-modal img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
        object-position: center;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
    }

    button:active {
        border: none;
    }

    input:focus,
    input:focus-visible {
        outline: none;
        border: none;
    }

    .dropdown-toggle::after {
        display: inline-block;
        margin-left: .255em;
        vertical-align: .255em;
        content: none !important;
        border-top: .3em solid;
        border-right: .3em solid transparent;
        border-bottom: 0;
        border-left: .3em solid transparent;
    }

    .dropdown-menu.show {
        display: block;
        width: 636px;
        cursor: pointer;
        max-height: 520.8px;
        overflow-y: scroll
    }

    .btn-default {
        background-color: #F53E3E;
        color: #fff;
    }

    .text-default {
        color: #F53E3E;
    }

    .btn-default:hover {
        background-color: #F53E3E;
        color: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-btn-default:first-child:active,
    .btn-btn-default:active,
    .btn-btn-default:focus,
    .btn-btn-default:focus-visible,
    .btn-default:active {
        background-color: #F53E3E!important;
        color: #fff!important;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-default-animation:hover {
        animation: pulse 2s infinite;

    }

    .jq-has-icon {
        padding: 14px;
        background-repeat: no-repeat;
        background-position: center;
    }

    .jq-icon-error {
        font-family: 'Roboto', sans-serif;
        background-image: linear-gradient(to right bottom, #F53E3E, #ff8383);
        background-color: #31708f;
        color: #d9edf7;
        font-size: 0.9rem;
        font-weight: 600;
        border-color: #bce8f1
    }

    .jq-icon-success {
        font-family: 'Roboto', sans-serif;
        background-image: linear-gradient(to right bottom, #1fd655, #83f28f);
        background-color: #31708f;
        color: #d9edf7;
        font-size: 0.9rem;
        font-weight: 600;
        border-color: #bce8f1
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(0.95);
        }

        100% {
            transform: scale(1);
        }
    }
</style>
@if (Route::currentRouteName() != 'user.order.indexUser')
    <style>
        @media (max-width: 768px) {
            .table {
                width: 100%;
                table-layout: fixed;
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 10px;
            }

            .table tbody td {
                display: block;
                text-align: right;
                border-bottom: 1px solid #ddd;
                position: relative;
                padding-left: 50%;
            }

            .table tbody td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 15px;
                font-weight: bold;
                text-align: left;
            }

            .table tfoot {
                display: block;
            }

            .table tfoot td {
                display: block;
                text-align: right;
            }

            .table tfoot tr {
                display: flex;
                justify-content: flex-end;
            }
        }
    </style>
@endif
@if (Route::currentRouteName() != 'user.index')
    <style>
        .absolute-category {
            z-index: 3;
        }
    </style>
@endif
@stack('libs-css')
@stack('custom-css')
