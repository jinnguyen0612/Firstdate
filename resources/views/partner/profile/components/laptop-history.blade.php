@php
    use App\Enums\Transaction\TransactionStatus;
    use App\Enums\Transaction\TransactionType;
    $first = $transactions->total == 0 ? 0 : $transactions->currentPage() * $transactions->perPage() - $transactions->perPage() + 1;
    $last =
        $transactions->currentPage() * $transactions->perPage() > $transactions->total
            ? $transactions->total
            : $transactions->currentPage() * $transactions->perPage();
    $total = $transactions->total;
@endphp
<div class="table-container pb-5">
    <div class="mail-option">

        <ul class="unstyled inbox-pagination">
            <li><span>{{ $first }} - {{ $last }} của {{ $total }} Giao dịch</span></li>
            <li>
                <button id="btn-previous" class="btn border" {{ $transactions->currentPage() == 1 ? 'disabled' : '' }}>
                    <i class="fa fa-angle-left pagination-left"></i>
                </button>
            </li>
            <li>
                <button id="btn-next" class="btn border" {{ !$transactions->hasMorePages() ? 'disabled' : '' }}>
                    <i class="fa fa-angle-right pagination-right"></i>
                </button>
            </li>
        </ul>
    </div>

    <div class="table-content-wrapper">
        <table class="table table-inbox table-hover table-responsive">
            <tbody>
                @foreach ($transactions as $transaction)
                    @php
                        if ($transaction->type == TransactionType::Deposit->value) {
                            $value = format_price($transaction->amount);
                            $color = 'text-primary';
                        } elseif (
                            $transaction->type == TransactionType::Withdraw->value ||
                            $transaction->type == TransactionType::Send->value ||
                            $transaction->type == TransactionType::Payment->value
                        ) {
                            $value = '- ' . format_price($transaction->amount);
                            $color = 'text-gray';
                        } elseif ($transaction->type == TransactionType::Receive->value) {
                            $value = '+ ' . format_price($transaction->amount);
                            $color = 'text-default';
                        }
                    @endphp
                    <tr
                        onclick="openNotification('{{ route('partner.profile.transaction.detail', ['code' => $transaction->code]) }}')">
                        <td class="inbox-small-cells">
                            <div class="icon-group text-center">
                                @if ($transaction->type == TransactionType::Deposit->value || $transaction->type == TransactionType::Receive->value)
                                    @include('partner.profile.icon.icon-deposit', [
                                        'width' => 30,
                                        'height' => 30,
                                    ])
                                @elseif($transaction->type == TransactionType::Withdraw->value || $transaction->type == TransactionType::Send->value)
                                    @include('partner.profile.icon.icon-withdraw', [
                                        'width' => 30,
                                        'height' => 30,
                                    ])
                                @elseif($transaction->type == TransactionType::Payment->value)
                                    @include('partner.profile.icon.icon-payment', [
                                        'width' => 30,
                                        'height' => 30,
                                    ])
                                @endif
                            </div>
                        </td>
                        <td class="view-message inbox-title text-center fw-semibold align-middle">
                            {{ $transaction->type == TransactionType::Payment->value? 'Phí chiếc khấu' : TransactionType::getDescription($transaction->type) }}</td>
                        <td class="view-message inbox-status text-center align-middle">
                            <span
                                class="badge {{ TransactionStatus::badgePartner($transaction->status) }}">{{ TransactionStatus::getDescription($transaction->status) }}</span>
                        </td>
                        <td class="view-message inbox-value align-middle">
                            <div class="fs-5 fw-semibold {{ $color }}">
                                <span>{{ $value }}</span>
                            </div>
                        </td>
                        <td class="view-message inbox-datetime align-middle text-end" style="font-weight: 500;">
                            <span class="text-gray">
                                {{ format_datetime($transaction->created_at, 'H:i d/m/Y') }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('custom-js')
    <script>
        function openNotification(route) {
            window.location.href = route
        }
    </script>
@endpush
