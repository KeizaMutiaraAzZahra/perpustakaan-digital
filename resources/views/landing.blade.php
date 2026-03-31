<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital Sekolah</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f4f7ff;
        }

        /* NAVBAR */
        .navbar {
            display: flex;
            justify-content: space-between;
            padding: 20px 60px;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #3f51b5;
            font-weight: bold;
        }

        .line {
            width: 2px;
            height: 25px;
            background: #3f51b5;
        }

        .navbar a {
            text-decoration: none;
            margin-left: 20px;
            color: #3f51b5;
        }

        /* HERO */
        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 60px;
        }

        .hero-text {
            max-width: 500px;
        }

        .hero-text h1 {
            font-size: 42px;
            color: #303f9f;
        }

        .hero-text p {
            margin: 20px 0;
            color: #555;
        }

        .btn {
            background: #3f51b5;
            color: white;
            padding: 12px 25px;
            border-radius: 6px;
            text-decoration: none;
        }

        .hero img {
            width: 380px;
        }

        /* FEATURES */
        .features {
            display: flex;
            justify-content: space-around;
            background: #3f51b5;
            padding: 40px;
            margin-top: 50px;
            color: white;
        }

        .feature {
            text-align: center;
            max-width: 200px;
        }

        /* FOOTER */
        .footer {
            text-align: center;
            padding: 20px;
            background: #303f9f;
            color: white;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <div class="logo">
            📖
            <div class="line"></div>
            <span>Perpustakaan Digital</span>
        </div>
    </div>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-text">
            <h1>Perpustakaan Digital Sekolah</h1>
            <p>
                Sistem perpustakaan berbasis digital untuk memudahkan siswa
                dalam mencari, meminjam, dan mengelola buku secara online.
            </p>
            <a href="/login" class="btn">Masuk Sistem</a>
        </div>

        <img src="{{ asset('img/landing.PNG') }}" alt="library">
    </section>

    <!-- FEATURES -->
    <section class="features">
        <div class="feature">
            <h3>📚 Koleksi Buku</h3>
            <p>Buku pelajaran & referensi lengkap</p>
        </div>
        <div class="feature">
            <h3>⚡ Akses Mudah</h3>
            <p>Bisa diakses kapan saja</p>
        </div>
        <div class="feature">
            <h3>👨‍🎓 Untuk Siswa</h3>
            <p>Khusus lingkungan sekolah</p>
        </div>
    </section>

    <!-- FOOTER -->
    <div class="footer">
        © 2026 Perpustakaan Digital Sekolah
    </div>

</body>
</html>