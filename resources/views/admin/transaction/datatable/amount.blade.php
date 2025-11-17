@if($type === \App\Enums\Transaction\TransactionType::Deposit->value)
    {{ format_price($amount) }}
@else
    {{ format_point($amount) }}
@endif

