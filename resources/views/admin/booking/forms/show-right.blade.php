@if ($booking->status === \App\Enums\Booking\BookingStatus::Completed->value)
    <div class="col-12 col-md-3">
        <div class="card mb-3">
            <div class="card-header">
                <i class="ti ti-file"></i>
                <span class="ms-2">{{ __('Hóa đơn thanh toán') }}</span>
            </div>
            <div class="card-body d-flex justify-content-between p-2">
                <a href="{{ route('admin.booking.invoice', $booking->id) }}"><button type="button"
                        class="btn btn-info btn-icon px-2">
                        Hoá đơn thanh toán
                    </button></a>
            </div>
        </div>
    </div>
@endif
