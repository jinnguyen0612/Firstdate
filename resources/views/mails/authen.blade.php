@php
    $settingRepository = app()->make(App\Admin\Repositories\Setting\SettingRepository::class);
    $siteLogoSettings = $settingRepository->findByField('setting_key', 'site_logo');
    $logo = $siteLogoSettings ? $siteLogoSettings->first()->plain_value : 'default-logo.png';
@endphp
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xác thực tài khoản</title>
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
    <table style="
            width: 100%;
            height: 100vh;
            border-collapse: collapse;
        ">
        <tr>
            <td
                style="
                    vertical-align: middle;
                    text-align: center;
                ">
                <div
                    style="
                        width: 100%;
                        max-width: 600px;
                        margin: 0 auto;
                        background: rgba(255, 255, 255, 0.95);
                        border-radius: 20px;
                        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
                        backdrop-filter: blur(10px);
                        -webkit-backdrop-filter: blur(10px);
                        padding: 40px;
                        text-align: left;
                        display: inline-block;
                    ">
                    <div style="text-align: center; margin-bottom: 30px;">
                        <img src="{{ asset($logo) }}" alt="Logo"
                            style="width: 160px; height: auto; margin-bottom: 20px;">
                        <h1
                            style="
                                color: #1a73e8;
                                margin: 0;
                                font-size: 28px;
                                font-weight: 600;
                            ">
                            Xác thực tài khoản</h1>
                    </div>

                    <div style="color: #5f6368; line-height: 1.6;">
                        <p style="font-size: 16px;">Xin chào <strong
                                style="color: #1a73e8;">{{ $fullname }}</strong>,</p>

                        <p style="font-size: 16px;">Chúng tôi vừa nhận được yêu cầu xác thực từ bạn.</p>

                        <p style="font-size: 16px;">Địa chỉ email: <strong
                                style="color: #1a73e8;">{{ $email }}</strong></p>

                        <p style="font-size: 16px; margin-bottom: 25px;">Để xác minh tài khoản, vui lòng sử dụng mã
                            xác thực sau:</p>
                    </div>

                    <div
                        style="
                            background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
                            padding: 30px;
                            border-radius: 15px;
                            text-align: center;
                            margin: 30px 0;
                        ">
                        <div
                            style="
                                font-size: 36px;
                                font-weight: bold;
                                color: white;
                                letter-spacing: 8px;
                                text-shadow: 0 2px 4px rgba(0,0,0,0.2);
                            ">
                            {{ $token_active_account }}</div>
                    </div>

                    <div
                        style="
                            padding: 20px;
                            background-color: #f8f9fa;
                            border-radius: 10px;
                            margin-top: 30px;
                            border-left: 4px solid #1a73e8;
                        ">
                        <p
                            style="
                                color: #5f6368;
                                font-size: 14px;
                                margin: 0;
                            ">
                            Lưu ý: Mã xác thực này sẽ hết hạn sau 30 phút. Vui lòng không chia sẻ mã này với bất kỳ
                            ai.</p>
                    </div>

                    <div style="text-align: center; margin-top: 40px;">
                        <p
                            style="
                                color: #5f6368;
                                font-size: 16px;
                                margin: 0;
                            ">
                            Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
                    </div>
                </div>
            </td>
        </tr>
        <div class="footer">
            <p>Email này được gửi tự động, vui lòng không trả lời.</p>
            <p>© 2025 Madarina. Tất cả các quyền được bảo lưu.</p>
        </div>
    </table>
</body>

</html>
