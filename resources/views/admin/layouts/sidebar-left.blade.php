<link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
<style>
    .btn-default-cms {
        background: linear-gradient(135deg,
                {{ optional($settings->firstWhere('setting_key', 'left_sidebar_bg_color_1'))->plain_value ?? '#defaultColor1' }},
                {{ optional($settings->firstWhere('setting_key', 'left_sidebar_bg_color_2'))->plain_value ?? '#defaultColor2' }});
        color: #ffffff;
    }

    .btn-default-cms:hover {
        color: #ffffff;
    }

    .page-wrapper {
        background-color: {{ optional($settings->firstWhere('setting_key', 'bg_color'))->plain_value ?? '#defaultBgColor' }};
    }

    .icon-bell {
        font-size: 1.5em;
        right: -3em;
        color: {{ optional($settings->firstWhere('setting_key', 'top_sidebar_text_color'))->plain_value ?? '#defaultTextColor' }};
        transition: color 0.3s ease;
    }

    .icon-bell:hover {
        color: #ff4d4d;
    }

    #header {
        background: linear-gradient(135deg,
                {{ optional($settings->firstWhere('setting_key', 'top_sidebar_bg_color_1'))->plain_value ?? '#defaultColor1' }},
                {{ optional($settings->firstWhere('setting_key', 'top_sidebar_bg_color_2'))->plain_value ?? '#defaultColor2' }});
        color: {{ optional($settings->firstWhere('setting_key', 'top_sidebar_text_color'))->plain_value ?? '#defaultTextColor' }};
    }

    .fancy-breadcrumb {
        width: 100%;
    }

    .breadcrumb-list {
        display: flex;
        flex-wrap: wrap;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .breadcrumb-item {
        position: relative;
        display: flex;
        align-items: center;
    }

    .breadcrumb-item:not(:last-child)::after {
        content: '→';
        margin: 0 0.5rem;
        color: black;
        animation: fadeIn 0.5s ease-in;
    }

    .breadcrumb-link {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        text-decoration: none;
        color: {{ optional($settings->firstWhere('setting_key', 'breadcrumbs_text_color'))->plain_value ?? '#defaultTextColor' }};
        background: linear-gradient(135deg,
                {{ optional($settings->firstWhere('setting_key', 'breadcrumbs_bg_color_1'))->plain_value ?? '#defaultColor1' }},
                {{ optional($settings->firstWhere('setting_key', 'breadcrumbs_bg_color_2'))->plain_value ?? '#defaultColor2' }});
        border-radius: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .breadcrumb-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .breadcrumb-icon {
        margin-right: 0.5rem;
        font-size: 1.1em;
    }

    .breadcrumb-text {
        font-weight: 500;
    }

    .breadcrumb-item.active .breadcrumb-link {
        pointer-events: none;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .breadcrumb-item {
        animation: slideIn 0.5s ease-out forwards;
        opacity: 0;
    }

    .breadcrumb-item:nth-child(1) {
        animation-delay: 0.1s;
    }

    .breadcrumb-item:nth-child(2) {
        animation-delay: 0.2s;
    }

    .breadcrumb-item:nth-child(3) {
        animation-delay: 0.3s;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .breadcrumb-item:nth-child(3) {
            margin-top: 16px;
        }
    }
</style>
<style>
    #searchMenuInput {
        background-color: #fff;
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 10px;
        color: black;
    }

    /* Navbar */
    .navbar-vertical {
        background: linear-gradient(135deg,
                {{ optional($settings->firstWhere('setting_key', 'left_sidebar_bg_color_1'))->plain_value ?? '#defaultColor1' }},
                {{ optional($settings->firstWhere('setting_key', 'left_sidebar_bg_color_2'))->plain_value ?? '#defaultColor2' }});
        /* Blue-purple gradient */
        color: #fff;
        transition: width 0.3s ease;
    }

    .navbar-vertical.navbar-expand-lg .navbar-collapse .dropdown-menu .dropdown-item.active,
    .navbar-vertical.navbar-expand-lg .navbar-collapse .nav-link.active {
        background: {{ optional($settings->firstWhere('setting_key', 'left_sidebar_selected_color'))->plain_value ?? '#defaultSelectedColor' }} !important;
    }

    .navbar-vertical.navbar-expand-lg .navbar-collapse .dropdown-menu .dropdown-item.active .nav-link-title,
    .navbar-vertical.navbar-expand-lg .navbar-collapse .dropdown-menu .dropdown-item.active .nav-link-icon,
    .navbar-vertical.navbar-expand-lg .navbar-collapse .nav-link.active .nav-link-title,
    .navbar-vertical.navbar-expand-lg .navbar-collapse .nav-link.active .nav-link-icon {
        color: {{ optional($settings->firstWhere('setting_key', 'left_sidebar_selected_text_color'))->plain_value ?? '#defaultSelectedTextColor' }} !important;
    }

    .navbar-brand img {
        transition: transform 0.3s ease;
    }

    .navbar-toggler {
        border: none;
    }

    /* Collapse sidebar on smaller screens */
    .navbar-collapse.collapse {
        transition: all 0.3s ease;
        animation: collapseExpand 0.3s ease-in-out;
    }

    @keyframes collapseExpand {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(0);
        }
    }

    /* Nav items */
    .navbar-nav .nav-item {
        border-radius: 8px;
        transition: background-color 0.3s ease, color 0.3s ease;
        display: flex;
    }

    /* Nav link icon */
    .nav-link-icon {
        margin-right: 10px;
        margin-bottom: 5px;
        font-size: 1.4em;
        color: {{ optional($settings->firstWhere('setting_key', 'left_sidebar_text_color'))->plain_value ?? '#defaultTextColor' }};
        /* Blue-purple color for icons */
        transition: transform 0.3s ease, color 0.3s ease;
    }

    /* Nav link title */
    .nav-link-title {
        font-size: 0.8rem;
        font-weight: 500;
        color: {{ optional($settings->firstWhere('setting_key', 'left_sidebar_text_color'))->plain_value ?? '#defaultTextColor' }};
        transition: color 0.3s ease;
    }

    /* Hover effects */
    .navbar-nav .nav-item:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .navbar-nav .nav-item:hover .nav-link-title,
    .navbar-nav .nav-item:hover .nav-link-icon {
        color: #cbd5e1;
    }

    .dropdown-menu {
        background: rgba(0, 0, 0, 0.5);
        border: none;
        animation: fadeIn 0.3s ease;
        transform-origin: top center;
    }

    /* Submenu items */
    .dropdown-item {
        color: #fff;
        transition: color 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #c4b5fd;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Toggle Sidebar */
    .sidebar-toggle-btn {
        position: fixed;
        /* Giữ nút cố định khi cuộn */
        top: 50%;
        /* Đặt ở giữa chiều cao màn hình */
        transform: translateY(-800%) rotate(-90deg);
        /* Căn giữa */
        left: 13.6rem;
        /* Lòi ra ngoài sidebar */
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg,
                {{ optional($settings->firstWhere('setting_key', 'left_sidebar_bg_color_1'))->plain_value ?? '#defaultColor1' }},
                {{ optional($settings->firstWhere('setting_key', 'left_sidebar_bg_color_2'))->plain_value ?? '#defaultColor2' }});
        /* Màu nền nút */
        color: white;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1050;
        /* Đảm bảo nút ở trên sidebar */
        transition: all 0.3s;
    }

    .sidebar-toggle-btn:hover {
        background-color: #495057;
        /* Thay đổi màu khi hover */
    }

    .sidebar-toggle-btn .arrow-icon {
        font-size: 16px;
        /* Kích thước biểu tượng */
        transition: transform 0.3s;
    }

    .sidebar-collapsed .sidebar-toggle-btn .arrow-icon {
        transform: rotate(180deg);
        /* Quay mũi tên khi sidebar đóng */
    }

    .sidebar-collapsed {
        width: 0 !important;
        /* Thu gọn sidebar */
        overflow: hidden;
        /* Ẩn nội dung bên trong khi thu gọn */
    }

    .sidebar-collapsed .navbar-collapse {
        display: none;
        /* Ẩn menu khi sidebar thu nhỏ */
    }

    .arrow-icon {
        transition: transform 0.3s ease;
        /* Hiệu ứng mượt khi xoay */
    }

    .arrow-left {
        transform: rotate(60deg);
        /* Xoay qua trái */
    }

    .arrow-right {
        transform: rotate(-120deg);
        /* Xoay qua phải */
    }
</style>
<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <x-link :href="route('admin.dashboard')">
                <img style="min-height: 80px"
                    src="{{ asset(optional($settings->firstWhere('setting_key', 'logo'))->plain_value ?? 'default-logo.png') }}"
                    alt="Tabler" class="navbar-brand-image">
            </x-link>
        </h1>
        <div class="p-3">
            <input type="text" class="form-control" id="searchMenuInput" placeholder="Tìm kiếm menu...">
        </div>
        <div class="navbar-nav d-lg-none flex-row">
            @include('admin.layouts.partials.account')
        </div>
        <div class="navbar-collapse collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                @foreach ($menu as $item)
                    @if (auth('admin')->user()->checkPermissions($item['permissions']) || in_array('mevivuDev', $item['permissions']))
                        <li @class(['nav-item', 'dropdown' => count($item['sub']) > 0])>
                            <x-admin-item-link-sidebar-left class="nav-link" :href="$routeName($item['routeName'], $item['param'] ?? [])" :dropdown="count($item['sub']) > 0 ? true : false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    {!! __($item['icon']) !!}
                                </span>
                                <span class="nav-link-title">
                                    {{ __($item['title']) }}
                                </span>
                            </x-admin-item-link-sidebar-left>
                            @if (count($item['sub']))
                                <div class="dropdown-menu">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            @foreach ($item['sub'] as $item)
                                                @if (auth('admin')->user()->checkPermissions($item['permissions']) || in_array('mevivuDev', $item['permissions']))
                                                    <x-admin-item-link-sidebar-left class="dropdown-item"
                                                        :href="$routeName($item['routeName'], $item['param'] ?? [])">
                                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                            {!! __($item['icon']) !!}
                                                        </span>
                                                        <span class="nav-link-title">
                                                            {{ __($item['title']) }}
                                                        </span>
                                                    </x-admin-item-link-sidebar-left>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</aside>

<!-- Nút Toggle -->
<button class="sidebar-toggle-btn d-none d-xl-block">
    <span class="arrow-icon"><i class="ti ti-triangle-filled"></i></span>
</button>

@push('custom-js')
    <script>
        $(document).ready(function() {
            $('#searchMenuInput').on('keyup', function() {
                const value = $(this).val().toLowerCase();
                $("#sidebar-menu ul.navbar-nav > li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endpush

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('aside');
        const toggleBtn = document.querySelector('.sidebar-toggle-btn');
        const arrowIcon = toggleBtn.querySelector('.arrow-icon');
        const layout = document.querySelector('.layout'); // Container chung
        let sidebarRemoved = false; // Trạng thái của sidebar
        let sidebarCache = null; // Biến lưu trữ sidebar

        toggleBtn.addEventListener('click', function() {
            if (!sidebarRemoved) {
                sidebarCache = sidebar;
                if (sidebarCache && sidebarCache.parentNode) {
                    sidebarCache.parentNode.removeChild(sidebarCache);
                }
                sidebarRemoved = true;
                toggleBtn.style.left = '-1rem';
                arrowIcon.classList.add('arrow-left'); // Thêm class xoay qua trái
                arrowIcon.classList.remove('arrow-right'); // Xóa class xoay qua phải
            } else {
                if (sidebarCache) {
                    layout.insertAdjacentElement('afterbegin', sidebarCache);
                    sidebarRemoved = false;
                    toggleBtn.style.left = '13.6rem';
                    arrowIcon.classList.add('arrow-right'); // Thêm class xoay qua phải
                    arrowIcon.classList.remove('arrow-left'); // Xóa class xoay qua trái
                } else {
                    console.error('Sidebar cache is null. Cannot re-add to DOM.');
                }
            }
        });
    });
</script>
