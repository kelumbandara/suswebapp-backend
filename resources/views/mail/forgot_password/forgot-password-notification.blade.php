<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification - ABA Group</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 30px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <div style="text-align: center; background-color: #1e3a8a; padding: 20px;">
            <img src="{{ asset('/assets/images/logo-blue.png') }}" alt="ABA Group Logo" style="width: 100px; height: auto;">
        </div>
        <div style="padding: 30px; text-align: center;">
            <h1 style="margin-bottom: 10px;">OTP Verification</h1>
            <p style="margin-bottom: 10px;">Hello,</p>
            <p style="margin-bottom: 10px;">Your OTP for password change is:</p>
            <div style="display: flex; justify-content: center; gap: 10px; margin-top: 20px; margin-left: 20px;">
                @foreach(str_split($otp) as $digit)
                    <div style="width: 50px; height: 50px; font-size: 24px; font-weight: bold; color: #1e3a8a; border: 2px solid #1e3a8a; border-radius: 8px; text-align: center; line-height: 50px;">
                        {{ $digit }}
                    </div>
                @endforeach
            </div>
            <p style="margin-top: 20px;">Please use this OTP to proceed with your password reset. This OTP expires in 5 minutes.</p>
            <p>If you did not request this change, please ignore this email.</p>
            <p><strong>The ABA Group Team</strong></p>
        </div>
        <div style="text-align: center; padding: 15px; background-color: #3b82f6;">
            <p style="font-size: 12px; color: #ffffff;">&copy; 2024 ABA Group. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
