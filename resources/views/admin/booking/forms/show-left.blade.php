<div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="title">
                    <img src="{{ asset(optional($settings->firstWhere('setting_key', 'logo'))->plain_value ?? 'default-logo.png') }}" style="width:100%; max-width:80px; max-height:80px">
                </td>
            </tr>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>MÃ LỊCH HẸN:</strong> #{{ $booking->code }}<br>
                                <strong>Thời gian tạo:</strong> {{ format_datetime($booking->created_at, 'd/m/Y H:i:s') }}<br>
                                <strong>Tên đối tác:</strong><x-link :href="route('admin.partner.edit', $booking->partner_id)" :title="$booking->partner['name']" /><br>
                                <strong>Địa chỉ:</strong> {{ $booking->partner['address'] .','}} <br>
                                {{ $booking->partner['district']['name'] .','}}
                                {{ $booking->partner['province']['name'] .'.'}}
                            </td>
                            <td>
                                <br>
                                <strong>Ngày đặt: </strong>{{ format_date($booking->date, 'd/m/Y') }}<br>
                                <strong>Thời gian đặt: </strong>{{ $booking->time ? format_time($booking->time):'Chưa duyệt' }}<br>
                                <strong>Trạng thái: </strong> <span @class(['badge', App\Enums\Booking\BookingStatus::from($booking->status)->badge()])>{{ \App\Enums\Booking\BookingStatus::getDescription($booking->status) }}</span>
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
                                <strong>NGƯỜI ĐẶT BÀN:</strong><br>
                                    <x-link :href="route('admin.user.edit', $booking->user_female_id)" :title="$booking->user_female['fullname']" /> <br>
                                    @if($booking->depositForUser($booking->user_female_id)==0)
                                        Chưa gửi tiền cọc
                                    @else
                                        Số tiền cọc: {{ format_point($booking->depositForUser($booking->user_female_id)) }} tim
                                    @endif
                            </td>
                            
                            <td>
                                <strong></strong><br>
                                <x-link :href="route('admin.user.edit', $booking->user_male_id)" :title="$booking->user_male['fullname']" /> <br>
                                @if($booking->depositForUser($booking->user_male_id)==0)
                                    Chưa gửi tiền cọc
                                @else
                                    Số tiền cọc: {{ format_point($booking->depositForUser($booking->user_male_id)) }} tim
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
</div>