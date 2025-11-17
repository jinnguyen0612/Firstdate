<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin hóa đơn') }}</h2>
        </div>
        @if($invoice != null)
        <div class="row card-body">
            <div class="col-md-12 col-sm-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-clock"></i> {{ __('Thời gian tạo') }}:</label>
                    <span>{{ $invoice->created_at }}</span>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <label class="control-label"><i class="ti ti-transform"></i> {{ __('Đối tác') }}:</label>
                <div class="mb-3 px-2">
                    <x-link :href="route('admin.partner.edit', $invoice->booking['partner']['id'])" :title="$invoice->booking['partner']['name']" /><br>
                    <span>{{ $invoice->booking['partner']['address'] .', '. $invoice->booking['partner']['province']['name'] .', '. $invoice->booking['partner']['district']['name'] }}</span>
                </div>
            </div>
            <div class="col-12">
                    <label class="control-label"><i class="ti ti-clock"></i> {{ __('Khách hàng') }}:</label>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <li><x-link :href="route('admin.user.edit', $invoice->booking['user_female']['id'])" :title="$invoice->booking['user_female']['fullname']" /></li>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <li><x-link :href="route('admin.user.edit', $invoice->booking['user_male']['id'])" :title="$invoice->booking['user_male']['fullname']" /></li>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-receipt"></i> {{ __('Hoá đơn thanh toán') }}:</label>
                    <div>
                        <img src="{{ asset($invoice->invoice) }}">
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-moneybag"></i> {{ __('Tổng hóa đơn') }}:</label>
                    <span>{{ format_price($invoice->total) }}</span>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-cash"></i> {{ __('Tiền chiếc khấu') }}:</label>
                    <span>{{ format_price($invoice->profit_split) }}</span>
                </div>
            </div>
        </div>
        @else
            <div class="row card-body">
                <div class="col-12">
                    <div class="mb-3">
                        <span class="text-danger fw-bold fs-3">{{ __('Không tìm thấy hóa đơn') }}</span> <br>
                        <span class="fst-italic fs-4">{{ __('Xin vui lòng chờ đối tác tiến hành chia sẻ thông tin') }}</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
