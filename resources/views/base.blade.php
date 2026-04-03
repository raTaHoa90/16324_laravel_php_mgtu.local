<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/bootstrap-5.3.8-examples/assets/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/base-styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <title>Document</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $(_=> $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } }) );
    </script>

    @stack('head')
</head>
<body>
    <header>
        <nav>
            <a href="/"><img src='/imgs/logo.png'></a>
            @yield('menu')
        </nav>
    </header>
    <main>
        @yield('base-content')
    </main>
    <footer> &copy; 2025-2026</footer>
</body>
</html>
