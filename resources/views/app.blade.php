<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Aplikasi KasirKu - Sistem Kasir Modern untuk Bisnis Retail dan UMKM">
        <meta name="keywords" content="kasir, point of sale, toko, retail, penjualan, umkm, bisnis, manajemen inventori, laporan penjualan, kasir digital">
        <meta name="author" content="KasirKu Team">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="robots" content="index, follow">
        <meta name="googlebot" content="index, follow">
        <meta name="theme-color" content="#3b82f6">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

        <!-- Canonical URL -->
        <link rel="canonical" href="{{ url()->current() }}">

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <title inertia>{{ config('app.name', 'Laravel') }} - Sistem Kasir Modern</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Open Graph / Social Media Meta Tags -->
        <meta property="og:title" content="{{ config('app.name', 'Laravel') }} - Sistem Kasir Modern">
        <meta property="og:description" content="Aplikasi KasirKu - Sistem Kasir Modern untuk Bisnis Retail dan UMKM">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
        <meta property="og:site_name" content="{{ config('app.name', 'Laravel') }}">
        <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">

        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@kasirku">
        <meta name="twitter:title" content="{{ config('app.name', 'Laravel') }} - Sistem Kasir Modern">
        <meta name="twitter:description" content="Aplikasi KasirKu - Sistem Kasir Modern untuk Bisnis Retail dan UMKM">
        <meta name="twitter:image" content="{{ asset('images/twitter-card.jpg') }}">
        <meta name="twitter:creator" content="@kasirku">

        <!-- Apple Touch Icons -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('apple-touch-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('apple-touch-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('apple-touch-icon-76x76.png') }}">

        <!-- Microsoft Tiles -->
        <meta name="msapplication-TileColor" content="#3b82f6">
        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
