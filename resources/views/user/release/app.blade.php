@extends('partner.layouts.guest')

@section('title', 'Download')

@push('libs-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endpush
@push('custom-css')
    @include('user.release.styles.app-download')
    @include('user.release.styles.swiper')
    @include('user.release.styles.select')
    @include('user.release.styles.question-select')
    @include('user.release.styles.login')

@endpush

@section('content')
    <main id="mainContent">
        <div class="btn-back d-none" id="btn-back-swiper-container">
            <span class="text-default p-3 fs-6 button-prev"><i class="fa fa-chevron-left me-2" aria-hidden="true"></i>Quay
                lại</span>
            <a href="{{ route('user.index') }}" class="button-close">
                <span id="btn-close" class="text-default p-3 fs-6"><i class="fa fa-times" aria-hidden="true"></i></span>
            </a>
        </div>
        <div id="user-info" class="d-none">
            <div class="swiper-container">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide text-start">
                            <h1 class="fw-bold mb-3">Chào bạn mới 👋</h1>
                            <h4 class="fw-medium">Cùng Firstdate hoàn thiện hồ sơ của bạn nhé!</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label class="control-label">Tên hoặc biệt danh của bạn là gì?</label>
                                        <x-input name="fullname" :value="old('fullname')" :placeholder="__('VD: Công Chúa Bong Bóng')"></x-input>
                                        <label class="sub-label">Hãy sử dụng thông tin thật bạn nhé!</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label class="control-label">Ngày sinh của bạn vào ngày mấy?</label>
                                        <x-input name="birthday" :value="old('birthday')" type="date"
                                            :placeholder="__('DD/MM/YYYY')"></x-input>
                                        <label class="sub-label">Hãy sử dụng ngày sinh thật bạn nhé!</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label class="control-label">Giới tính của bạn?</label>
                                        <div class="group-radio-button">
                                            <input type="radio" name="gender" id="male"
                                                value="{{ App\Enums\User\Gender::Male->value }}">
                                            <label class="me-2 " for="male">Nam</label>
                                            <input type="radio" name="gender" id="female"
                                                value="{{ App\Enums\User\Gender::Female->value }}">
                                            <label class="me-2 " for="female">Nữ</label>
                                            <input type="radio" name="gender" id="other"
                                                value="{{ App\Enums\User\Gender::Other->value }}">
                                            <label class="me-2 " for="other">Không tiết lộ</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide text-start">
                            <h1 class="fw-bold mb-3">Chọn ảnh đại diện</h1>
                            <h4 class="fw-medium">Cho Firstdate thấy tấm ảnh đẹp nhất của bạn!</h4>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-2 text-center">
                                        <div class="d-flex justify-content-center align-items-center flex-column">
                                            <label class="picture border-custom swiper-no-swiping" for="picture_input"
                                                tabIndex="0" aria-label="Chọn ảnh đại diện">
                                                <span class="picture_image" data-empty="true">Choose an image</span>
                                            </label>
                                        </div>
                                        <input type="file" name="avatar" id="picture_input" accept="image/*">
                                        <label class="sub-label" id="avatar-subtitle">Đây là ảnh hiển thị đầu tiên
                                            trong hồ sơ của
                                            bạn</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide text-start">
                            <h1 class="fw-bold mb-3">Chọn ảnh hồ sơ</h1>
                            <h4 class="fw-medium">Những tấm ảnh có thể nói lên phong cách của bạn!</h4>

                            <div class="col-12">
                                <div class="mb-2 text-center d-flex justify-content-center align-items-center flex-column">

                                    <div class="image-grid" id="imageGrid">
                                        <div class="image-slot" data-index="0"><span class="plus">+</span></div>
                                        <div class="image-slot" data-index="1"><span class="plus">+</span></div>
                                        <div class="image-slot" data-index="2"><span class="plus">+</span></div>
                                        <div class="image-slot" data-index="3"><span class="plus">+</span></div>
                                        <div class="image-slot" data-index="4"><span class="plus">+</span></div>
                                        <div class="image-slot" data-index="5"><span class="plus">+</span></div>
                                    </div>
                                    <input type="file" name="thumbnails" id="filePicker" accept="image/*" multiple
                                        hidden>

                                    <label class="sub-label">Ảnh hồ sơ giúp đối phương có thể hình dung rõ hơn về bạn khi
                                        chưa có
                                        cơ hội gặp nhau 💖</label>
                                </div>
                            </div>

                        </div>
                        <div class="swiper-slide text-start">
                            <h1 class="fw-bold mb-3">Tiêu chí hẹn hò</h1>
                            <h4 class="fw-medium">Để Firstdate tìm người phù hợp cho bạn nhé!</h4>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label class="control-label">Độ tuổi mong muốn hẹn hò</label>
                                        <div class="row">
                                            <div class="col-6 input-age-find">
                                                <input class="form-control" type="number" min="18" max="99"
                                                    inputmode="numeric" name="min_age_find" placeholder="18">
                                                <span class="stick-label" id="minAge">tuổi</span>
                                            </div>
                                            <div class="col-6 input-age-find">
                                                <input class="form-control" type="number" min="18" max="99"
                                                    inputmode="numeric" name="max_age_find" placeholder="90">
                                                <span class="stick-label" id="maxAge">tuổi</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label class="control-label">Đối tượng bạn đang tìm kiếm</label>

                                        <button type="button" class="fd-select w-100" id="btnLookingFor">
                                            <span id="textLookingFor" class="fd-placeholder">VD: Nam</span>
                                            <span class="fd-chev"><i class="fa fa-chevron-right"
                                                    aria-hidden="true"></i></span>
                                        </button>
                                        <input type="hidden" name="looking_for" id="valLookingFor">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label class="control-label">Mối quan hệ bạn muốn hướng đến</label>

                                        <button type="button" class="fd-select w-100" id="btnRel">
                                            <span id="textRel" class="fd-placeholder text-start">
                                                VD: {{ head(array_values($relationships ?? [])) ?? 'Hẹn hò vui vẻ' }}
                                            </span>
                                            <span class="fd-chev"><i class="fa fa-chevron-right"
                                                    aria-hidden="true"></i></span>
                                        </button>
                                        <input type="hidden" name="relationship" id="valRel">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label class="control-label">Khung giờ hẹn hò lý tưởng</label>

                                        <button type="button" class="fd-select w-100" id="btnDatingTime">
                                            <span id="textDatingTime" class="fd-placeholder text-start">
                                                VD: {{ head(array_values($datingTime ?? [])) ?? '19h00 - 22h00' }}
                                            </span>
                                            <span class="fd-chev"><i class="fa fa-chevron-right"
                                                    aria-hidden="true"></i></span>
                                        </button>
                                        <input type="hidden" name="dating_time" id="valDatingTime">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide text-start">
                            <h1 class="fw-bold mb-3">Mô tả về bạn</h1>
                            <h4 class="fw-medium">Để đối phương hiểu hơn về bạn thông qua những câu hỏi 💖</h4>

                            <div class="row">
                                <input type="hidden" name="answer">
                                <div class="col-12 mb-1">
                                    <div id="qaGrid" class="qa-grid scroll-y">
                                        <div class="qa-card" data-slot="1" data-is-required="true">
                                            <div class="qa-card-main">
                                                <span class="plus">+</span>
                                            </div>
                                        </div>
                                        <div class="qa-card" data-slot="2" data-is-required="true">
                                            <div class="qa-card-main">
                                                <span class="plus">+</span>
                                            </div>
                                        </div>
                                        <div class="qa-card" data-slot="3" data-is-required="false">
                                            <div class="qa-card-main">
                                                <span class="plus">+</span>
                                            </div>
                                        </div>
                                        <div class="qa-card" data-slot="4" data-is-required="false">
                                            <div class="qa-card-main">
                                                <span class="plus">+</span>
                                            </div>
                                        </div>
                                        <div class="qa-card" data-slot="5" data-is-required="false">
                                            <div class="qa-card-main">
                                                <span class="plus">+</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-center justify-content-center align-items-center">
                                    <span class="btn text-default fs-6 fs-sm-text d-none" id="btnQaAdd">+ Thêm câu
                                        hỏi</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide text-start">
                            <h1 class="fw-bold mb-3">Hỗ trợ đối phương</h1>
                            <div class="img-container mb-3 d-flex justify-content-center">
                                <img class="img-support" src="{{ asset('user/assets/release/svg/support.svg') }}"
                                    alt="">
                            </div>
                            <h4 class="fw-medium text-center title-support">Chính sách hỗ trợ 25 <img
                                    src="{{ asset('user/assets/release/svg/Heart.svg') }}" alt=""> cho đối phương
                            </h4>

                            <div class="row content-container scroll-y">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <p class="content-support">Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                            sed do eiusmod tempor
                                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                            nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                                            fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                                            culpa qui officia deserunt mollit anim id est laborum.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div
                class="text-center d-flex justify-content-center align-items-center flex-column button-group-container fixed-bottom">
                <div class="btn-group mt-3 button-next-container">
                    <button class="btn btn-default button-next" id="btnNext">Tiếp tục</button>
                </div>
                <div class="text-center label-info mb-3">
                    <label class="sub-label text-gray"><img src="{{ asset('user/assets/release/svg/info.svg') }}"
                            alt=""> Bạn có thể thay đổi lại lựa chọn này trong tài khoản</label>
                </div>
                <div class="btn-group label-info mb-3">
                    <button class="btn btn-default btnSubmitRegister" type="button" data-subsidy="0">Không chấp nhận
                        hỗ
                        trợ</button>
                </div>
                <div class="btn-group label-info mb-3">
                    <button class="btn text-default btnSubmitRegister" type="button" data-subsidy="1">Chấp nhận hỗ
                        trợ</button>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 px-4 mx-auto d-flex justify-content-center align-items-center flex-column d-none"
            id="app-info" style="min-height: 80vh;">
            <div class="image-container">
                <img src="{{ asset('user/assets/release/svg/logo-default.svg') }}" class="img-fluid" alt="App Download">
            </div>
            <div class="content-container text-center">
                <h2>👋 Chào mừng đến với Firstdate💖</h2>
                <p class="text-start">Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus earum modi
                    perspiciatis porro exercitationem sint dolorum at repudiandae nisi, perferendis sed quis eligendi minus
                    ullam excepturi dolorem quia maxime veniam?</p>
                <p class="mb-1 fw-medium">Ứng dụng sẽ được ra mắt trên CH Play Store và App Store dự kiến vào
                    ngày
                    <strong>16/12/2022</strong>.
                </p>
                <div class="flex social-btns">
                    <a class="app-btn blu d-flex align-items-center vert" href="http:apple.com">
                        <i class="fab fa-apple"></i>
                        <p>Get it on <br /> <span class="big-txt">App Store</span></p>
                    </a>

                    <a class="app-btn blu d-flex align-items-center vert" href="http:google.com">
                        <i class="fab fa-google-play"></i>
                        <p>Get it on <br /> <span class="big-txt">CH Play</span></p>
                    </a>
                </div>

            </div>
        </div>
    </main>

    <div id="qaSheetRoot">
        <div class="fd-backdrop" id="qaBackdrop"></div>

        <!-- Sheet chọn CÂU HỎI -->
        <div class="fd-sheet" id="qaSheetQuestion" role="dialog" aria-modal="true">
            <div class="fd-grabber"></div>
            <div class="fd-head">
                <div class="fd-title">Chọn câu hỏi</div><button class="fd-close" data-close>&times;</button>
            </div>
            <ul class="fd-list" id="qaQuestionList"></ul>
            <div class="fd-safe"></div>
        </div>

        <!-- Sheet chọn CÂU TRẢ LỜI -->
        <div class="fd-sheet" id="qaSheetAnswer" role="dialog" aria-modal="true">
            <div class="fd-grabber"></div>
            <div class="fd-head">
                <div class="fd-title" id="qaAnswerHeader">Chọn câu trả lời</div><button class="fd-close"
                    data-close>&times;</button>
            </div>
            <ul class="fd-list" id="qaAnswerList"></ul>
            <div class="fd-safe"></div>
        </div>
    </div>


    <div id="fdSheetRoot">
        <!-- Backdrop -->
        <div class="fd-sheet-backdrop" id="fdBackdrop"></div>

        <!-- Sheet: SINGLE select (Đối tượng) -->
        <div class="fd-sheet" id="sheetLookingFor" role="dialog" aria-modal="true" aria-labelledby="lfTitle">
            <div class="fd-grabber"></div>
            <div class="fd-sheet-head">
                <div class="fd-sheet-title" id="lfTitle">Đối tượng tìm kiếm</div>
            </div>
            <ul class="fd-sheet-list">
                @foreach ($lookingFor ?? [] as $key => $label)
                    <li data-value="{{ $key }}">{{ $label }}</li>
                @endforeach
            </ul>
            <div class="fd-safe"></div>
        </div>

        <!-- Sheet: MULTI select (Mối quan hệ) -->
        <div class="fd-sheet" id="sheetRel" role="dialog" aria-modal="true" aria-labelledby="relTitle">
            <div class="fd-grabber"></div>
            <div class="fd-sheet-head">
                <div class="fd-sheet-title" id="relTitle">Mối quan hệ hướng đến</div>
            </div>
            <ul class="fd-sheet-list fd-has-check">
                @foreach ($relationships ?? [] as $key => $label)
                    <li>
                        <label>
                            <span class="fs-6 fw-thin">{{ $label }}</span>
                            <input type="checkbox" value="{{ $key }}">
                        </label>
                    </li>
                @endforeach
            </ul>
            <div class="fd-sheet-actions">
                <button type="button" class="btn btn-link" style="text-decoration:none;" data-close>Huỷ</button>
                <button type="button" class="btn btn-default" id="relOk">Xong</button>
            </div>
            <div class="fd-safe"></div>
        </div>

        <div class="fd-sheet" id="sheetDatingTime" role="dialog" aria-modal="true" aria-labelledby="datingTimeTitle">
            <div class="fd-grabber"></div>
            <div class="fd-sheet-head">
                <div class="fd-sheet-title" id="datingTimeTitle">Mối quan hệ hướng đến</div>
            </div>
            <ul class="fd-sheet-list fd-has-check">
                @foreach ($datingTime ?? [] as $key => $label)
                    <li>
                        <label>
                            <span class="fs-6 fw-thin">{{ $label }}</span>
                            <input type="checkbox" value="{{ $key }}">
                        </label>
                    </li>
                @endforeach
            </ul>
            <div class="fd-sheet-actions">
                <button type="button" class="btn btn-link" style="text-decoration:none;" data-close>Huỷ</button>
                <button type="button" class="btn btn-default" id="datingTimeOk">Xong</button>
            </div>
            <div class="fd-safe"></div>
        </div>
    </div>
@endsection

@push('libs-js')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/framework7@latest/framework7-bundle.min.js"></script>
@endpush

@push('custom-js')
    @include('user.release.scripts.app-download')
    @include('user.release.scripts.swiper')
    @include('user.release.scripts.imageInput')
    @include('user.release.scripts.inputGallery')
    @include('user.release.scripts.select')
    @include('user.release.scripts.question-select')
    @include('user.release.scripts.register')
@endpush
