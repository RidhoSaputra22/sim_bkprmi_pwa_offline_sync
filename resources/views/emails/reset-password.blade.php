<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SIM BKPRMI</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        line-height: 1.6;
        color: #333;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 600px;
        margin: 20px auto;
        background: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .header {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        color: #ffffff;
        padding: 30px 20px;
        text-align: center;
    }

    .header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: bold;
    }

    .header p {
        margin: 5px 0 0;
        font-size: 14px;
        opacity: 0.9;
    }

    .content {
        padding: 30px 20px;
    }

    .greeting {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #1e40af;
    }

    .message {
        font-size: 15px;
        margin-bottom: 20px;
        color: #555;
    }

    .button-container {
        text-align: center;
        margin: 30px 0;
    }

    .reset-button {
        display: inline-block;
        padding: 14px 40px;
        background: #1e3a8a;
        color: #ffffff !important;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        font-size: 16px;
        box-shadow: 0 4px 6px rgba(30, 64, 175, 0.3);
        transition: all 0.3s ease;
    }

    .reset-button:hover {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        color: #ffffff !important;
        box-shadow: 0 6px 8px rgba(30, 64, 175, 0.4);
    }

    .info-box {
        background: #eff6ff;
        border-left: 4px solid #3b82f6;
        padding: 15px;
        margin: 20px 0;
        border-radius: 4px;
    }

    .info-box p {
        margin: 5px 0;
        font-size: 14px;
        color: #1e40af;
    }

    .warning-box {
        background: #fef3c7;
        border-left: 4px solid #f59e0b;
        padding: 15px;
        margin: 20px 0;
        border-radius: 4px;
    }

    .warning-box p {
        margin: 5px 0;
        font-size: 14px;
        color: #92400e;
    }

    .footer {
        background: #f9fafb;
        padding: 20px;
        text-align: center;
        border-top: 1px solid #e5e7eb;
    }

    .footer p {
        margin: 5px 0;
        font-size: 13px;
        color: #6b7280;
    }

    .link {
        color: #3b82f6;
        text-decoration: none;
        word-break: break-all;
    }

    .divider {
        margin: 20px 0;
        border-top: 1px solid #e5e7eb;
    }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>SIM BKPRMI</h1>
            <p>Sistem Informasi Manajemen</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">Halo, {{ $name }}!</div>

            <div class="message">
                Kami menerima permintaan untuk mereset password akun Anda di Sistem Informasi Manajemen BKPRMI.
                Klik tombol di bawah ini untuk membuat password baru:
            </div>

            <!-- Reset Button -->
            <div class="button-container">
                <a href="{{ url('password/reset/'.$token.'?email='.urlencode($email)) }}" class="reset-button">
                    Reset Password
                </a>
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <p><strong>⏰ Link ini berlaku selama 60 menit</strong></p>
                <p>Setelah melewati batas waktu, Anda perlu request ulang reset password.</p>
            </div>

            <!-- Alternative Link -->
            <div class="message">
                Jika tombol di atas tidak berfungsi, salin dan paste link berikut ke browser Anda:
            </div>
            <p style="word-break: break-all; background: #f3f4f6; padding: 10px; border-radius: 4px; font-size: 13px;">
                <a href="{{ url('password/reset/'.$token.'?email='.urlencode($email)) }}" class="link">
                    {{ url('password/reset/'.$token.'?email='.urlencode($email)) }}
                </a>
            </p>

            <div class="divider"></div>

            <!-- Warning Box -->
            <div class="warning-box">
                <p><strong>⚠️ Perhatian Keamanan:</strong></p>
                <p>Jika Anda tidak meminta reset password, abaikan email ini. Akun Anda tetap aman dan tidak ada
                    perubahan yang dilakukan.</p>
            </div>

            <div class="message">
                Untuk keamanan akun Anda, jangan bagikan link ini kepada siapapun. Tim BKPRMI tidak akan pernah meminta
                password Anda melalui email atau media lainnya.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>BKPRMI - Badai Komandai Pengajian Remaja Muhammadiyah Indonesia</strong></p>
            <p>© {{ date('Y') }} SIM BKPRMI. All rights reserved.</p>
            <p style="margin-top: 10px;">
                Butuh bantuan? Hubungi administrator sistem Anda.
            </p>
        </div>
    </div>
</body>

</html>
