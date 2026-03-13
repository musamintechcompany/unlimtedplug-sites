<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Onboarding - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .onboarding-container { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); max-width: 500px; width: 100%; }
        .logo { text-align: center; margin-bottom: 30px; }
        .logo h1 { font-size: 28px; color: #1f2937; margin-bottom: 8px; font-weight: 700; }
        .logo p { color: #6b7280; font-size: 14px; }
        h2 { color: #1f2937; margin-bottom: 8px; font-size: 24px; font-weight: 600; }
        .subtitle { color: #6b7280; margin-bottom: 30px; font-size: 14px; line-height: 1.6; }
        .info-box { background: #eff6ff; border-left: 4px solid #3b82f6; padding: 15px; margin-bottom: 25px; border-radius: 6px; }
        .info-box p { color: #1e40af; font-size: 13px; line-height: 1.6; }
        .form-group { margin-bottom: 20px; }
        label { display: block; color: #1f2937; font-weight: 600; margin-bottom: 8px; font-size: 14px; }
        input { width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; transition: all 0.3s; }
        input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        .password-wrapper { position: relative; }
        .password-wrapper input { padding-right: 45px; }
        .password-toggle { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #9ca3af; font-size: 18px; transition: color 0.3s; }
        .password-toggle:hover { color: #1f2937; }
        .error { color: #dc2626; font-size: 12px; margin-top: 5px; display: flex; align-items: center; gap: 4px; }
        .error i { font-size: 12px; }
        .btn { width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; margin-top: 10px; transition: transform 0.2s, box-shadow 0.2s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3); }
        .btn:active { transform: translateY(0); }
    </style>
</head>
<body>
    <div class="onboarding-container">
        <div class="logo">
            <h1><i class="fas fa-lock"></i> {{ config('app.name') }}</h1>
            <p>Admin Panel Setup</p>
        </div>

        <h2>Welcome! 👋</h2>
        <p class="subtitle">Let's set up your admin account to get started managing the platform.</p>

        <div class="info-box">
            <p><strong>First Admin Setup</strong><br>You're creating the first administrator account. This account will have full access to manage all platform features and settings.</p>
        </div>

        <form method="POST" action="{{ route('admin.onboarding') }}">
            @csrf
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <div class="error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" required>
                    <span class="password-toggle" onclick="togglePassword('password')"><i class="fas fa-eye"></i></span>
                </div>
                @error('password')
                    <div class="error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                    <span class="password-toggle" onclick="togglePassword('password_confirmation')"><i class="fas fa-eye"></i></span>
                </div>
            </div>

            <button type="submit" class="btn">Create Admin Account</button>
        </form>
    </div>

    <script>
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            const icon = input.nextElementSibling.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
