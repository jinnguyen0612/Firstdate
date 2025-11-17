<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo sự cố xe cộ</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        body {
            font-family: 'Roboto', Arial, sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 20px;
            color: #2d3748;
            line-height: 1.6;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .header {
            background: linear-gradient(135deg, #e53e3e 0%, #f56565 100%);
            padding: 25px 30px;
            color: white;
        }

        .header-icon {
            display: inline-block;
            float: left;
            margin-right: 15px;
            padding: 8px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
        }

        h1 {
            font-size: 22px;
            margin: 0;
            padding: 0;
            font-weight: 600;
        }

        .subtitle {
            margin-top: 5px;
            opacity: 0.9;
            font-size: 14px;
        }

        .content {
            padding: 25px 30px;
        }

        .alert-box {
            background: #fff5f5;
            border-left: 4px solid #f56565;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-title {
            color: #c53030;
            font-weight: 600;
            margin: 0 0 5px 0;
        }

        .info-group {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #edf2f7;
        }

        .info {
            margin-bottom: 12px;
            display: flex;
            align-items: baseline;
        }

        .label {
            font-weight: 500;
            color: #4a5568;
            width: 140px;
            display: inline-block;
        }

        .value {
            color: #2d3748;
            font-weight: 400;
            flex: 1;
        }

        .status-active {
            color: #2f855a;
            font-weight: 500;
            background: #e6fffa;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 14px;
        }

        .status-inactive {
            color: #c53030;
            font-weight: 500;
            background: #fff5f5;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 14px;
        }

        .map-container {
            height: 200px;
            background: #edf2f7;
            border-radius: 4px;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }

        .map-placeholder {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .button {
            display: inline-block;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 500;
            text-align: center;
            flex: 1;
            transition: background-color 0.2s;
        }

        .button-primary {
            background: #3182ce;
            color: white;
        }

        .button-primary:hover {
            background: #2b6cb0;
        }

        .button-secondary {
            background: #718096;
            color: white;
        }

        .button-secondary:hover {
            background: #4a5568;
        }

        .footer {
            background: #f7fafc;
            padding: 15px 30px;
            font-size: 13px;
            color: #718096;
            border-top: 1px solid #edf2f7;
            text-align: center;
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }

            .container {
                width: 100%;
            }

            .info {
                flex-direction: column;
            }

            .label {
                margin-bottom: 5px;
                width: 100%;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="header-icon">⚠️</div>
            <h1>Thông báo sự cố xe cộ</h1>
        </div>

        <div class="content">
            <div class="alert-box">
                <div class="alert-title">Cần hỗ trợ khẩn cấp</div>
                <p>Xe gặp sự cố và cần được hỗ trợ tại địa điểm dưới đây.</p>
            </div>
            <div class="info-group">
                <div class="info">
                    <span class="label">Vị trí:</span>
                    <span class="value">{{ $location }}</span>
                </div>
                <div class="info">
                    <span class="label">Trạng thái xe:</span>
                    <span class="{{ $status ? 'status-active' : 'status-inactive' }}">
                        {{ $status ? 'Còn hoạt động' : 'Không hoạt động' }}
                    </span>
                </div>
            </div>

            <div class="info-group">
                <div class="info">
                    <span class="label">Mô tả sự cố:</span>
                    <span class="value">{{ $messageContent }}</span>
                </div>
            </div>

            <div class="action-buttons">
                <a href="tel:0328414771" class="button button-secondary">Gọi hotline</a>
            </div>
        </div>

        {{-- <div class="footer">
            <div>© {{ $year }} {{ $company }}. Hệ thống theo dõi và hỗ trợ xe.</div>
            <div style="margin-top: 8px;">Hotline: {{ $hotline }} - Email: {{ $support_email }}</div>
        </div> --}}
    </div>
</body>

</html>
