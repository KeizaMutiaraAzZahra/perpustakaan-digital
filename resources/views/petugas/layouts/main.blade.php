<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas - Perpustakaan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style-petugas.css') }}">
</head>
<body>
    <div class="dashboard-container">
        {{-- Memanggil Sidebar --}}
        @include('petugas.partials.sidebar')

        <div class="main-wrapper">
            {{-- Memanggil Header --}}
            @include('petugas.partials.header')

            {{-- Area Konten Dinamis --}}
            <main class="content-body">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>