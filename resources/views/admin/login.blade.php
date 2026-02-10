<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - OSSAGA Valentine</title>
    <link rel="icon" href="{{ asset('img/logo.svg') }}" type="image/svg+xml">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Courier New', monospace;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border: 4px solid #000;
            box-shadow: 8px 8px 0 #000;
            padding: 40px;
            max-width: 400px;
            width: 100%;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            font-size: 2rem;
            color: #d50000;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .login-header p {
            color: #666;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 0.95rem;
            color: #333;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #000;
            font-family: 'Courier New', monospace;
            font-size: 1rem;
            background: #fff;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            box-shadow: 4px 4px 0 #ff8fab;
            border-color: #ff8fab;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: #d50000;
            color: white;
            border: 4px solid #000;
            box-shadow: 4px 4px 0 #000;
            font-family: 'Courier New', monospace;
            font-size: 1.2rem;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-login:hover {
            background: #b00000;
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0 #000;
        }

        .btn-login:active {
            transform: translate(4px, 4px);
            box-shadow: none;
        }

        .error-message {
            background: #ffebee;
            border: 2px solid #d50000;
            color: #d50000;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>🔐 Admin Login</h1>
            <p>OSSAGA Valentine Dashboard</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                <strong>⚠️ Error:</strong>
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                    placeholder="admin@example.com"
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    placeholder="••••••••"
                >
            </div>

            <button type="submit" class="btn-login">
                Masuk
            </button>
        </form>

        <div class="back-link">
            <a href="/">← Kembali ke Halaman Utama</a>
        </div>
    </div>
</body>
</html>
