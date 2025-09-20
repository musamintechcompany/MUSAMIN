<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Your Email - {{ config('app.name') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #374151;
            background-color: #f9fafb;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f9fafb;
            padding: 40px 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .header p {
            color: #e5e7eb;
            font-size: 16px;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            color: #4b5563;
            margin-bottom: 30px;
            line-height: 1.7;
        }
        .code-container {
            background-color: #f3f4f6;
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        .code {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 8px;
            color: #667eea;
            font-family: 'Courier New', monospace;
            margin-bottom: 10px;
        }
        .code-label {
            font-size: 14px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .warning {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 16px 20px;
            margin: 30px 0;
            border-radius: 0 8px 8px 0;
        }
        .warning p {
            color: #92400e;
            font-size: 14px;
            margin: 0;
        }
        .footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .social-links {
            margin-top: 20px;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #9ca3af;
            text-decoration: none;
            font-size: 18px;
        }
        @media (max-width: 600px) {
            .email-wrapper { padding: 20px 10px; }
            .header, .content, .footer { padding: 30px 20px; }
            .code { font-size: 28px; letter-spacing: 6px; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="header">
                <h1>🔐 Email Verification</h1>
                <p>Secure your {{ config('app.name') }} account</p>
            </div>

            <div class="content">
                <div class="greeting">Hello {{ $user->name }}! 👋</div>

                <div class="message">
                    Welcome to {{ config('app.name') }}! We're excited to have you on board. To complete your registration and secure your account, please verify your email address using the code below:
                </div>

                <div class="code-container">
                    <div class="code">{{ $verificationCode }}</div>
                    <div class="code-label">Verification Code</div>
                </div>

                <div class="message">
                    Simply enter this code on the verification page to activate your account and start exploring all the amazing features we have to offer.
                </div>

                <div class="warning">
                    <p><strong>⏰ Important:</strong> This verification code will expire in 5 minutes for security reasons. If you didn't create an account with us, please ignore this email.</p>
                </div>
            </div>

            <div class="footer">
                <p>Need help? Contact our support team anytime.</p>
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>

                <div class="social-links">
                    <a href="#">📧</a>
                    <a href="#">🐦</a>
                    <a href="#">📘</a>
                    <a href="#">📷</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
