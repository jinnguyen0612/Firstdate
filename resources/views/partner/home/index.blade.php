@php use App\Enums\Booking\BookingStatus;@endphp
@extends('partner.layouts.master')
@section('title', __($title))

@push('libs-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('custom-css')
    @include('partner.home.styles.style')
@endpush

@section('content')
    <div class="container">
        <div class="nav-tabs-container">
            <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
                <li class="nav-item nav-item-first" role="presentation">
                    <button class="nav-link py-1 active" id="new-tab" data-bs-toggle="tab" data-bs-target="#new"
                        type="button" role="tab" aria-controls="new" aria-selected="true">Lịch hẹn mới
                    </button>
                </li>
                <li class="nav-item nav-item-last" role="presentation">
                    <button class="nav-link py-1" id="confirm-tab" data-bs-toggle="tab" data-bs-target="#confirm"
                        type="button" role="tab" aria-controls="confirm" aria-selected="false">Đã duyệt
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="myTabContent">
            <div class="container">
                <form id="filterForm">
                    <div class="row">
                        <div class="col-7 col-md-8">
                            <div class="input-group mb-3 shadow-sm rounded-pill overflow-hidden">
                                <input name="search" type="text" class="form-control search-input border-0"
                                    placeholder="Tìm tên, mã cuộc hẹn, thời gian" aria-label="Search term">
                                <button class="btn search-btn search-button" type="button">
                                    <i class="ti ti-search animated-icon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-5 col-md-4">
                            <div class="">
                                <input name="date" class="form-control" id="datePicker">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade show active" id="new" role="tabpanel" aria-labelledby="new-tab">
                <div id="tab-new-deal">
                    @include('partner.home.tabs.new_deal', ['newBookings' => $newBookings])
                </div>
            </div>
            <div class="tab-pane fade" id="confirm" role="tabpanel" aria-labelledby="confirm-tab">
                <div class="scroll-x-view badge-container">
                    @foreach ($bookingStatus as $key => $value)
                        @php
                            $status = BookingStatus::from($key);
                        @endphp
                        @if ($key != BookingStatus::Pending->value)
                            <span class="badge-button cursor-pointer {{$key == BookingStatus::Confirmed->value ? 'active' : ''}}"
                                data-status="{{ $key }}">{{ $status->getPartnerDescription() }}</span>
                        @endif
                    @endforeach
                </div>
                <div id="tab-list-booking">
                    @include('partner.home.tabs.list_booking', ['confirmBookings' => $confirmBookings])
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="rejectModalLabel">Từ chối cuộc hẹn</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            Bạn có đồng ý từ chối cuộc hẹn này?
                            <input type="hidden" name="id" value="">
                        </div>
                        <div class="input-container mb-3">
                            <label class="form-label">Lí do từ chối</label>
                            {{-- <input name="note" type="text" class="form-control" placeholder="Lí do từ chối"> --}}
                            @foreach ($rejectReason as $reason)
                                <div class="mb-2">
                                    <input class="radio-group" type="radio" name="reason"
                                        id="reason{{ $reason->id }}" value="{{$reason->reason}}">
                                    <label class="form-check-label" for="reason{{ $reason->id }}">
                                        {{ $reason->reason }}
                                    </label>
                                </div>
                            @endforeach
                            <div class="mb-2">
                                <input class="radio-group" type="radio" name="reason" id="reasonDifferent"
                                    value="">
                                <label class="form-check-label" for="reasonDifferent">
                                    Khác
                                </label>
                            </div>
                            <input name="note" type="hidden" class="form-control" placeholder="Lí do từ chối">
                        </div>
                    </div>
                    <div class="modal-footer align-items-center justify-content-around">
                        <button type="button" class="btn text-default rounded py-2 px-4"
                            data-bs-dismiss="modal">Hủy</button>
                        <button id="btn-accept-reject" type="button" class="btn btn-default rounded py-2 px-4">Đồng
                            ý</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('libs-js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

@push('custom-js')
    @include('partner.booking.scripts.api')
    @include('partner.home.scripts.script')
    @include('partner.booking.scripts.accept-reject')
    @include('partner.home.scripts.radio-group')
    <script>
        flatpickr("#datePicker", {
            altInput: true,
            altFormat: "d/m/Y", // hiển thị cho người dùng
            dateFormat: "Y-m-d", // gửi dữ liệu dạng yyyy-mm-dd
            allowInput: false
        });
    </script>
@endpush
