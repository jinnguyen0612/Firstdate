@php
    $settingRepository = app()->make(App\Admin\Repositories\Setting\SettingRepository::class);
    $settings = $settingRepository->getAll();
    $exchangePercent = (int) $settings->where('setting_key', 'exchange_percent')->first()->plain_value;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Báo Đơn Hàng Mới</title>
    <style>
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>

<body
    style="
    margin: 0;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f8f9fa;
    min-height: 100vh;
    background-image: url('{{ asset('assets/images/bg-mail-authen.jpg') }}');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
">
    <div
        style="
        max-width: 600px;
        margin: 0 auto;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    ">
        <!-- Header -->
        <div
            style="
            background-color: #4CAF50;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        ">
            <h1 style="margin: 0; font-size: 24px;">Đơn Hàng Mới</h1>
            <p style="margin: 10px 0 0; font-size: 16px;">Mã đơn hàng: {{ $instance->code }}</p>
        </div>

        <!-- Order Info -->
        <div style="padding: 20px;">
            <div
                style="
                background-color: #f8f9fa;
                border-radius: 6px;
                padding: 15px;
                margin-bottom: 20px;
            ">
                <h2
                    style="
                    margin: 0 0 15px;
                    color: #2c3e50;
                    font-size: 18px;
                    border-bottom: 1px solid #dee2e6;
                    padding-bottom: 10px;
                ">
                    Thông Tin Đơn Hàng</h2>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <p style="margin: 5px 0; color: #666;">
                            <strong>Ngày đặt:</strong><br>
                            {{ format_datetime($instance->created_at) }}
                        </p>
                        <p style="margin: 5px 0; color: #666;">
                            <strong>Phương thức thanh toán:</strong><br>
                            {{ \App\Enums\Payment\PaymentMethod::getDescription($instance->payment_method->value) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div
                style="
                background-color: #f8f9fa;
                border-radius: 6px;
                padding: 15px;
                margin-bottom: 20px;
            ">
                <h2
                    style="
                    margin: 0 0 15px;
                    color: #2c3e50;
                    font-size: 18px;
                    border-bottom: 1px solid #dee2e6;
                    padding-bottom: 10px;
                ">
                    Thông Tin Khách Hàng</h2>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <p style="margin: 5px 0; color: #666;">
                            <strong>Họ tên:</strong><br>
                            {{ $instance->fullname }}
                        </p>
                        <p style="margin: 5px 0; color: #666;">
                            <strong>Số điện thoại:</strong><br>
                            {{ $instance->phone }}
                        </p>
                        <p style="margin: 5px 0; color: #666;">
                            <strong>Địa chỉ:</strong><br>
                            {{ $instance->address }}, {{ $instance->ward->name }}, {{ $instance->district->name }},
                            {{ $instance->province->name }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div
                style="
                background-color: #f8f9fa;
                border-radius: 6px;
                padding: 15px;
                margin-bottom: 20px;
            ">
                <h2
                    style="
                    margin: 0 0 15px;
                    color: #2c3e50;
                    font-size: 18px;
                    border-bottom: 1px solid #dee2e6;
                    padding-bottom: 10px;
                ">
                    Chi Tiết Sản Phẩm</h2>

                <div style="overflow-x: auto;">
                    <table
                        style="
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 15px;
                ">
                        <thead>
                            <tr style="background-color: #e9ecef;">
                                <th style="padding: 10px; text-align: left; border-bottom: 1px solid #dee2e6;">Sản
                                    phẩm
                                </th>
                                <th style="padding: 10px; text-align: right; border-bottom: 1px solid #dee2e6;">Giá
                                </th>
                                <th style="padding: 10px; text-align: right; border-bottom: 1px solid #dee2e6;">SL
                                </th>
                                <th style="padding: 10px; text-align: right; border-bottom: 1px solid #dee2e6;">Tổng
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($instance->details as $item)
                                <tr>
                                    <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">
                                        <div style="display: flex; align-items: center;">
                                            <img src="{{ asset($item->product_avatar) }}" alt="Product"
                                                style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                            <div>
                                                <div style="font-weight: 500;">{{ $item->product_name }}</div>
                                                @if ($item->product_variation_id)
                                                    <div style="font-size: 12px; color: #666;">
                                                        @foreach ($item->productVariation->attributeVariations as $attributeVariation)
                                                            {{ $attributeVariation->name }}@if (!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 10px; text-align: right; border-bottom: 1px solid #dee2e6;">
                                        {{ format_price($item->unit_price) }}
                                    </td>
                                    <td style="padding: 10px; text-align: right; border-bottom: 1px solid #dee2e6;">
                                        {{ $item->qty }}
                                    </td>
                                    <td style="padding: 10px; text-align: right; border-bottom: 1px solid #dee2e6;">
                                        {{ format_price($item->unit_price * $item->qty) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Order Summary -->
                <div
                    style="
                    border-top: 2px solid #dee2e6;
                    padding-top: 15px;
                    margin-top: 15px;
                ">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="color: #666;">Tạm tính: </span>
                        <span style="margin-left: 4px">{{ format_price($instance->total) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="color: #666;">Giảm giá: </span>
                        <span style="margin-left: 4px">{{ format_price(-($instance->discount_value ?? 0)) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="color: #666;">Phí vận chuyển: </span>
                        <span style="margin-left: 4px">{{ format_price($instance->shipping_fee ?? 0) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="color: #666;">Giảm giá vận chuyển: </span>
                        <span
                            style="margin-left: 4px">{{ format_price(-$instance->voucher_shipping_discount_value ?? 0) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="color: #666;">Giảm giá tiền hàng: </span>
                        <span
                            style="margin-left: 4px">{{ format_price(-$instance->voucher_product_discount_value ?? 0) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="color: #666;">Giảm giá bằng điểm: </span>
                        <span
                            style="margin-left: 4px">{{ format_price(-($instance->points * $exchangePercent ?? 0)) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="color: #666;">Phụ thu: </span>
                        <span style="margin-left: 4px">{{ format_price($instance->surcharge ?? 0) }}</span>
                    </div>
                    <div
                        style="
                        display: flex;
                        justify-content: space-between;
                        margin-top: 10px;
                        padding-top: 10px;
                        border-top: 1px solid #dee2e6;
                        font-weight: bold;
                        font-size: 18px;
                    ">
                        <span>Tổng cộng: </span>
                        <span
                            style="color: #4CAF50;margin-left: 4px">{{ format_price($instance->total + $instance->surcharge + $instance->shipping_fee - $instance->discount_value - $instance->points * $exchangePercent - $instance->voucher_product_discount_value - $instance->voucher_shipping_discount_value) }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div style="text-align: center; color: #666; font-size: 14px; margin-top: 30px;">
                <p style="margin: 5px 0;">Cảm ơn bạn đã đặt hàng tại hệ thống của chúng tôi!</p>
                <p style="margin: 5px 0;">Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.</p>
            </div>

            <div class="footer">
                <p>Email này được gửi tự động, vui lòng không trả lời.</p>
                <p>© 2025 Madarina. Tất cả các quyền được bảo lưu.</p>
            </div>
        </div>
    </div>
</body>

</html>
