<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Change Verification - {{ $organizationName }} Group</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 30px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <div style="text-align: center; background-color: #1e3a8a; padding: 15px;">
            <img src="{{ $logoUrl ?? asset('/assets/images/logo-blue.png') }}" alt="{{ $organizationName }} Logo" style="width: 100px; height: auto;">
        </div>
        <div style="padding: 30px; text-align: center;">
            <h1 style="margin-bottom: 10px;">Email Change Verification</h1>
            <p style="font-size: 16px; color: #333;">Hello <strong>{{ $name }}</strong>,</p>
            <p style="margin-bottom: 10px;">Your OTP to confirm your email change is:</p>

            <div style="text-align: center; margin-top: 20px;">
                @foreach(str_split($otp) as $digit)
                    <span style="display: inline-block; width: 50px; height: 50px; margin: 0 5px; font-size: 24px; font-weight: bold; color: #1e3a8a; border: 2px solid #1e3a8a; border-radius: 8px; text-align: center; line-height: 50px;">
                        {{ $digit }}
                    </span>
                @endforeach
            </div>

            <p style="margin-top: 20px;">Please use this OTP to proceed with changing your email. This OTP expires in 10 minutes.</p>
            <p>If you did not request an email change, please ignore this email or contact support.</p>
            <p style="font-size: 16px; color: #333; font-weight: bold; margin: 5px 0;">The {{ $organizationName }} Group Team</p>
        </div>
        <div style="text-align: center; padding: 15px; background-color: #3b82f6;">
            <p style="font-size: 12px; color: #ffffff;">&copy; 2025 {{ $organizationName }} Group. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
