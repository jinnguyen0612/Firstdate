<div class="col-12 col-md-9">
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ asset(optional($settings->firstWhere('setting_key', 'logo'))->plain_value ?? 'default-logo.png') }}"
                                    style="width:100%; max-width:100px; max-height:100px">
                            </td>

                            <td>
                                <strong>Mã giao dịch:</strong> #{{ $transaction->code }}<br>
                                <strong>Thời gian:</strong> {{ format_datetime($transaction->created_at) }}<br>
                                <strong>Loại giao dịch:</strong> <span
                                    @class([
                                        'badge',
                                        App\Enums\Transaction\TransactionType::from($transaction->type)->badge(),
                                    ])>{{ \App\Enums\Transaction\TransactionType::getDescription($transaction->type) }}</span>
                                <br>
                                <strong>Trạng thái:</strong> <span
                                    @class([
                                        'badge',
                                        App\Enums\Transaction\TransactionStatus::from(
                                            $transaction->status)->badge(),
                                    ])>{{ \App\Enums\Transaction\TransactionStatus::getDescription($transaction->status) }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>NGƯỜI GỬI:</strong><br>
                                @if ($transaction->from_type === \App\Models\User::class)
                                    @if (empty($transaction->from['id']) || empty($transaction->from['fullname']))
                                        <span>Người dùng: {{ $transaction->from_name }}</span><br>
                                    @else
                                        <x-link :href="route('admin.user.edit', $transaction->from['id'])" :title="$transaction->from['fullname']" /><br>
                                    @endif
                                @elseif($transaction->from_type === \App\Models\Partner::class)
                                    @if (empty($transaction->from['id']) || empty($transaction->from['name']))
                                        <span>Đối tác: {{ $transaction->from_name }}</span><br>
                                    @else
                                        <x-link :href="route('admin.partner.edit', $transaction->from['id'])" :title="$transaction->from['name']" /><br>
                                    @endif
                                @else
                                    <span class="badge badge-danger">Hệ thống</span><br>
                                @endif

                                @if(!empty($transaction->from))
                                    @if ($transaction->from_type === \App\Models\User::class && !empty($transaction->from['id']))
                                        {{ $transaction->from['province']['name'] . ',' }} <br>
                                        {{ $transaction->from['district']['name'] . '.' }}<br>
                                    @elseif($transaction->from_type === \App\Models\Partner::class && !empty($transaction->from['id']))
                                        {{ $transaction->from['address'] . ',' }} <br>
                                        {{ $transaction->from['province']['name'] . ',' }} <br>
                                        {{ $transaction->from['district']['name'] . '.' }}<br>
                                    @else
                                        <br><br><br>
                                    @endif
                                @endif
                            </td>

                            <td>
                                <strong>NGƯỜI NHẬN</strong><br>
                                @if ($transaction->to_type === \App\Models\User::class)
                                    @if (empty($transaction->to['id']) || empty($transaction->to['fullname']))
                                        <span>Người dùng: {{ $transaction->to_name }}</span><br>
                                    @else
                                        <x-link :href="route('admin.user.edit', $transaction->to['id'])" :title="$transaction->to['fullname']" /><br>
                                    @endif
                                @elseif($transaction->to_type === \App\Models\Partner::class)
                                    @if (empty($transaction->to['id']) || empty($transaction->to['name']))
                                        <span>Đối tác: {{ $transaction->to_name }}</span><br>
                                    @else
                                        <x-link :href="route('admin.partner.edit', $transaction->to['id'])" :title="$transaction->to['name']" /><br>
                                    @endif
                                @else
                                    <span class="badge badge-danger">Hệ thống</span><br>
                                @endif

                                @if(!empty($transaction->to))
                                    @if ($transaction->to_type === \App\Models\User::class)
                                        {{ $transaction->to['province']['name'] . ',' }} <br>
                                        {{ $transaction->to['district']['name'] . '.' }}<br>
                                    @elseif($transaction->to_type === \App\Models\Partner::class)
                                        {{ $transaction->to['address'] . ',' }}
                                        <br>{{ $transaction->to['province']['name'] . ',' }} <br>
                                        {{ $transaction->to['district']['name'] . '.' }}
                                    @else
                                        <br><br><br>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="total">
                <td></td>

                <td>
                    @if ($transaction->type === \App\Enums\Transaction\TransactionType::Deposit->value)
                        Số tiền: {{ format_price($transaction->amount) }}
                    @else
                        Số tim: {{ format_point($transaction->amount) }}
                    @endif
                </td>
            </tr>
        </table>
        <div>
            <h3 class="text-right font-bold">Mô tả:</h3>
            <p class="text-right">{{ $transaction->description }}</p>
        </div>
    </div>
</div>
