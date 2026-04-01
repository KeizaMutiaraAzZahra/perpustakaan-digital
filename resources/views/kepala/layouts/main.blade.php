<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleguide.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- BOOTSTAP ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- BOOTSTRAP FONT -->
     <link href="https://fonts.googleapis.com/css2?family=Protest+Strike&display=swap" rel="stylesheet">
    
</head>
<body>

<div class="dashboard-kepala">

    {{-- Header --}}
    @include('kepala.partials.header')

    {{-- Sidebar --}}
    @include('kepala.partials.sidebar')

    {{-- Main Content --}}
    <main class="body">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('kepala.partials.footer')

</div>

</body>
</html>