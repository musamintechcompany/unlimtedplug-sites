<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2>Verify Your Email Address</h2>
    <p>Hi {{ $user->name }},</p>
    <p>Thank you for registering with {{ config('app.name') }}. To complete your registration, please verify your email address using the code below:</p>
    
    <div style="background-color: #f5f5f5; padding: 20px; text-align: center; margin: 20px 0; border-radius: 5px;">
        <h1 style="letter-spacing: 5px; color: #333; margin: 0;">{{ $code }}</h1>
    </div>
    
    <p>This code will expire in 15 minutes.</p>
    <p>If you didn't create this account, please ignore this email.</p>
    
    <p>Best regards,<br>{{ config('app.name') }} Team</p>
</div>
