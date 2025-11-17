        @php
            use App\Enums\Booking\BookingStatus;
        @endphp

        <div class="col-12 col-sm-6 col-lg-4 mb-3">
            <div class="card card-deal justify-content-between p-3 cursor-pointer" data-url="{{ route('partner.booking.detail', ['code' => $code]) }}">

                <div class="d-flex justify-content-between mb-2">
                    <span class="fs-6 align-self-start ms-1">#{{ $code }}</span>
                    <span
                        @class([
                            'fs-6 align-self-end fw-semibold me-1',
                            BookingStatus::from($status)->getPartnerTextColor(),
                        ])>{{ BookingStatus::from($status)->getPartnerDescription() }}</span>
                </div>

                <div class="row">
                    <div class="col-2 icon-box align-self-center justify-content-center">
                        <svg class="w-100" viewBox="0 0 29 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.9139 13.0819C19.4427 13.5532 18.6573 13.5532 18.186 13.0819L12.7848 7.69274L4.26602 16.1994L3.46852 15.4382C2.05477 14.0244 2.05477 11.7286 3.46852 10.3148L8.59185 5.19149C10.0056 3.77774 12.3014 3.77774 13.7152 5.19149L19.9139 11.3782C20.3852 11.8494 20.3852 12.6107 19.9139 13.0819ZM20.7598 10.5202C21.7023 11.4627 21.7023 12.9973 20.7598 13.9398C19.2252 15.4744 17.606 14.2057 17.3402 13.9398L12.7968 9.39649L6.06643 16.1269C5.59518 16.5982 5.59518 17.3594 6.06643 17.8307C6.53768 18.3019 7.29893 18.3019 7.78227 17.8307L13.3648 12.2482L14.2227 13.1061L8.64018 18.6886C8.16893 19.1598 8.16893 19.9211 8.64018 20.3923C9.11143 20.8636 9.87268 20.8636 10.356 20.3923L15.9385 14.8098L16.7964 15.6677L11.2139 21.2502C10.7427 21.7215 10.7427 22.4827 11.2139 22.954C11.6852 23.4252 12.4464 23.4252 12.9177 22.954L18.5002 17.3715L19.3581 18.2294L13.7756 23.8119C13.3043 24.2832 13.3043 25.0444 13.7756 25.5157C14.2468 25.9869 15.0081 25.9869 15.4793 25.5157L25.5327 15.4382C26.9464 14.0244 26.9464 11.7286 25.5327 10.3148L20.4093 5.19149C19.0198 3.80191 16.7723 3.77774 15.3585 5.11899L20.7598 10.5202Z"
                                fill="#F53E3E" />
                        </svg>
                    </div>
                    <div class="col-10 align-self-center">
                        <span>{{ $userFemale }}</span> <br>
                        <span>{{ $userMale }}</span> <br>
                        @if ($time)
                            <span>Hẹn lúc: {{ $time }}</span> <br>
                        @else
                            <span>Mong muốn: {{ $from }} - {{ $to }}</span> <br>
                        @endif
                        <span>{{ format_date_vn ($date) }}</span>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-1 mb-2">

                    @if ($status == App\Enums\Booking\BookingStatus::Pending->value)
                        <button type="button" class="btn btn-outline-warning rounded-5 me-2 btn-reject" data-id="{{ $bookingId }}">Từ chối</button>
                        <button type="button" class="btn btn-warning rounded-5 text-white">Chốt</button>
                    @elseif($status == App\Enums\Booking\BookingStatus::Confirmed->value)
                        <button type="button" class="btn btn-default btn-to-processing" data-id="{{ $bookingId }}">Đang diễn ra</button>
                    @elseif($status == App\Enums\Booking\BookingStatus::Processing->value)
                        <a class="btn btn-success" data-id="{{ $bookingId }}">Hoàn thành</a>
                    @endif
                </div>
            </div>
        </div>
