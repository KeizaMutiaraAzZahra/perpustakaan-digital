<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Perpustakaan Digital</title>
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

<div class="login-container">

    <div class="login-card">

        <!-- LEFT -->
        <div class="login-form">
            <h2>LOGIN</h2>
            <div class="divider"></div>

            <form method="POST" action="/login">
                <!-- Laravel -->
                <!-- @csrf -->

                <div class="input-group">
                    <span>👤</span>
                    <input type="text" name="email" placeholder="Username / Email" required>
                </div>

                <div class="input-group">
                    <span>🔒</span>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <button type="submit" class="btn-login">Login</button>

                <p class="register-text">
                    Belum punya akun? <a href="#">Registrasi</a>
                </p>
            </form>
        </div>

        <!-- RIGHT -->
        <div class="login-info">
            <h3>Perpustakaan Digital</h3>
            <img src="{{ asset('img/landing.svg') }}" alt="logo">
        </div>

    </div>

</div>

</body>
</html>