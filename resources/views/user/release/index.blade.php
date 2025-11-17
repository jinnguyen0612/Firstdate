@extends('partner.layouts.guest')

@section('title', 'Giới thiệu')

@push('libs-css')
@endpush
@push('custom-css')
    @include('user.release.styles.about')
@endpush

@section('content')
    <main id="mainContent">
        {{-- 1) Modal khởi động --}}
        <div class="modal fade" id="splashModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="justify-content-center align-items-center d-flex modal-dialog modal-dialog-centered">
                <div class="text-center">
                    <div class="pb-3">
                        <img src="{{ asset('user/assets/release/svg/Logo.svg') }}" alt="">
                    </div>
                    <div class="fs-3 fw-bold px-5">1000 tin nhắn không bằng 1 lần gặp gỡ</div>
                </div>
            </div>
        </div>

        {{-- 2) Nội dung trang: ẩn tạm thời cho đến khi modal đóng --}}
        <div class="d-none pageContent" id="welcome">
            {{-- ... toàn bộ nội dung trang của bạn ... --}}
            <div class="container">
                <div class="text-center image-container mb-3 p-3">
                    <img class="img-fluid" src="{{ asset('user/assets/release/svg/Humans.svg') }}" alt="">
                </div>
                <h2 class="welcome-title">Welcome headline</h2>
                <div class="slide-container">
                    <div class="slide fade show">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                        aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                        culpa qui officia deserunt mollit anim id est laborum.
                    </div>
                    <div class="slide fade">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sequi quibusdam officiis, sapiente
                        cupiditate alias magni magnam laboriosam nemo doloremque quam ut animi. Voluptates sequi iure quae
                        neque, doloremque maiores pariatur?
                    </div>
                    <div class="slide fade">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates vero deserunt iste similique
                        aliquid doloremque repellat quibusdam adipisci ea est consectetur odit quae animi fugiat tempora,
                        molestiae nam libero quisquam?
                    </div>
                </div>
                <div class="dots-container">
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
            </div>
            <div class="fixed-bottom pb-3">
                <div class="btn-group">
                    <a class="btn fs-5 btn-default" title="Next" id="next">
                        WOW
                    </a>
                </div>
                <div class="btn-group">
                    <a class="btn fs-5 btn-gray" title="Bắt đầu ngay" id="end">
                        Bắt đầu ngay
                    </a>
                </div>
            </div>
        </div>

        <div class="d-none pageContent" id="login">
            <div class="justify-content-center align-items-center d-flex" style="height: 50vh;">
                <div class="text-center mt-5">
                    <div class="pb-5">
                        <img src="{{ asset('user/assets/release/svg/Logo.svg') }}" alt="">
                    </div>
                    <div class="fs-1 fw-bold px-5 mx-3">1000 tin nhắn không bằng 1 lần gặp gỡ</div>
                </div>
            </div>
            <div class="fixed-bottom pb-3">
                <div class="btn-group">
                    <a href="{{route('user.login')}}" class="btn btn-white fs-5">
                        Tôi đã có tài khoản
                    </a>
                </div>
                <div class="btn-group">
                    <a href="{{route('user.register')}}" class="btn btn-white fs-5">
                        Tôi chưa có tài khoản
                    </a>
                </div>
                <p class="text-center content-group fs-6">
                    Khi tiếp tục đồng nghĩa rằng bạn đã đồng ý với <a href="#"
                        class="fw-medium text-decoration-underline text-black">điều khoản</a> và <a href="#"
                        class="fw-medium text-decoration-underline text-black">chính
                        sách</a> của chúng tôi
                </p>
            </div>
        </div>
    </main>
@endsection

@push('custom-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Khởi tạo và hiển thị modal ngay khi trang load
            var modalEl = document.getElementById('splashModal');
            var splash = new bootstrap.Modal(modalEl, {
                backdrop: 'static',
                keyboard: false
            });
            splash.show();

            // Sau 2 giây: ẩn modal và hiện nội dung trang
            setTimeout(function() {
                splash.hide();
                document.getElementById('welcome').classList.remove('d-none');
            }, 1000);

            // Phòng trường hợp người dùng tự đóng/modal bị can thiệp: khi modal ẩn thì vẫn hiện nội dung
            modalEl.addEventListener('hidden.bs.modal', function() {
                document.getElementById('welcome').classList.remove('d-none');
            });
        });
    </script>

    @include('user.release.scripts.slider')
@endpush
