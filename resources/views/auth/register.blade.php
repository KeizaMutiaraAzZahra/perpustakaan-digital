<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi - Perpustakaan Digital</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="register-body">

    <div class="register-container">
        <div class="register-card">
            
            <div class="register-form-section">
                <h2 class="register-title">REGISTRASI</h2>
                <div class="register-divider"></div>

                <form action="/register" method="POST">
                @csrf
                    <div class="register-input-group">
                        <label>Nama :</label>
                        <input type="text" name="name" required>
                    </div>

                    <div class="register-input-group">
                        <label>Username :</label>
                        <input type="text" name="username" required>
                    </div>

                    <div class="register-input-group">
                        <label>Email :</label>
                        <input type="email" name="email" required>
                    </div>

                    <div class="register-input-group">
                        <label>Password :</label>
                        <input type="password" name="password" required>
                    </div>

                    <button type="submit" class="register-btn">Registrasi</button>
                </form>
            </div>

        </div>
    </div>

</body>
</html>