@php
    use App\Enums\Transaction\TransactionType;
    use App\Enums\Transaction\TransactionStatus;
@endphp
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
    <a href="{{ route('partner.profile.transaction.detail', ['code' => $transaction->code]) }}">
        <div class="card d-flex flex-row p-3 mb-3 shadow-sm">
            <div class="flex-shrink-0 me-2">
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
            </div>
            <div class="mobile-card-content flex-grow-1">
                <div class="fs-5 fw-semibold">
                    {{ $transaction->type == TransactionType::Payment->value ? 'Phí chiếc khấu' : TransactionType::getDescription($transaction->type) }}
                    </td>
                </div>
                <div class="fs-6 {{ TransactionStatus::textPartner($transaction->status) }} fw-semibold">
                    {{ TransactionStatus::getDescription($transaction->status) }}
                </div>
            </div>
            <div class="mobile-card-content flex-grow-1 text-end">
                <div class="fs-5 fw-semibold text-default">
                    <span>{{ $value }}</span>
                </div>
                <div class="fs-6 text-gray" style="font-weight: 500">
                    {{ $transaction->created_at->format('H:i d/m/Y') }}
                </div>
            </div>
        </div>
    </a>
@endforeach

