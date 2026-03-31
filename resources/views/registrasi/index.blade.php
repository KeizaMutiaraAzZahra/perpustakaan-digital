<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Perpustakaan Digital</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="wrapper">
        <div class="auth-card">
            <h1 class="auth-title">REGISTRASI</h1>
            <div class="underline"></div>

            <form action="#" method="POST">
                <div class="input-group">
                    <label for="nama">Nama :</label>
                    <input type="text" id="nama" name="nama" required>
                </div>

                <div class="input-group">
                    <label for="username">Username :</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="input-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="input-group">
                    <label for="password">Password :</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn-submit">Registrasi</button>
            </form>
            
            <p class="footer-text">Sudah punya akun? <a href="#">Login di sini</a></p>
        </div>
    </div>

</body>
</html>