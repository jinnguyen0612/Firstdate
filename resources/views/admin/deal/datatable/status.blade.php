<span @class([
    'badge',
    App\Enums\Deal\DealStatus::from($status)->badge(),
])>
    {{ \App\Enums\Deal\DealStatus::getDescription($status) }}
</span>
