@php
    use App\Enums\Transaction\TransactionStatus;
    use App\Enums\Transaction\TransactionType;
    $time =
        $transaction->status == TransactionStatus::Pending->value
            ? 'Thực hiện lúc: ' . format_datetime($transaction->created_at, 'H:i d/m/Y')
            : 'Hoàn thành lúc: ' . format_datetime($transaction->updated_at, 'H:i d/m/Y');
    if ($transaction->type == TransactionType::Deposit->value) {
        $title = 'Nạp tiền vào ví DatePoint';
    } elseif ($transaction->type == TransactionType::Withdraw->value) {
        $title = 'Rút tiền khỏi ví DatePoint';
    } elseif ($transaction->type == TransactionType::Payment->value) {
        $title = 'Phí chiếc khấu';
    }

    $value = format_price((float)$transaction->amount);

@endphp
<div class="transaction-wrapper row mt-5 pt-5">
    <div class="col-4 align-self-center">
        <div class="transaction-header text-center mb-3">
            <div class="icon-wrapper mb-2">
                @if ($transaction->type == TransactionType::Deposit->value || $transaction->type == TransactionType::Receive->value)
                    @include('partner.profile.icon.icon-deposit', ['width' => 60, 'height' => 60])
                @elseif($transaction->type == TransactionType::Withdraw->value || $transaction->type == TransactionType::Send->value)
                    @include('partner.profile.icon.icon-withdraw', ['width' => 60, 'height' => 60])
                @elseif($transaction->type == TransactionType::Payment->value)
                    @include('partner.profile.icon.icon-payment', ['width' => 60, 'height' => 60])
                @endif
            </div>
            <div class="text-center mb-2">
                <span
                    class="badge {{ TransactionStatus::from($transaction->status)->badge() }} fs-6 py-2 px-3">{{ TransactionStatus::getDescription($transaction->status) }}</span>
            </div>
            <span class="fs-5 fw-semibold">{{ $title }}</span>
            <div class="d-flex justify-content-center align-items-center my-3">
                <span class="text-default fs-2 me-2" style="font-weight: 500">
                    {{ $value }}
                </span>
            </div>
            <span class="fs-6" style="color: gray">{{ $time }}</span>
        </div>
    </div>
    <div class="col-8 align-self-end">
        <div class="transaction-body">
            <div class="d-flex justify-content-between mb-3">
                <span class="fs-5">Mã giao dịch</span>
                <span class="fs-5 text-end" style="font-weight: 500;">{{ $transaction->code }} <button class="btn p-1"
                        onclick="copyToClipboard('{{ $transaction->code }}')"><i class="ti ti-copy"></i></button></span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span class="fs-5">Loại giao dịch</span>
                <span class="fs-5 text-end" style="font-weight: 500;">{{ $title }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span class="fs-5">Người nhận</span>
                <span class="fs-5 text-end"
                    style="font-weight: 500;">{{ $transaction->receiver ?? 'Hệ thống FirstDate' }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span class="fs-5">Nội dung</span>
                <span class="fs-5 text-wrap text-end" style="font-weight: 500;">{{ $transaction->description }}</span>
            </div>
        </div>
    </div>
</div>
