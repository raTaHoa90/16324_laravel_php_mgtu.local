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

    @yield('head')
</head>
<body>
    <header>
        <nav>
            <img src='/imgs/logo.png'>
            <ul class="left-menu">
                <li><a class="btn btn-light"><i class="fa fa-archive"></i> каталог</a></li>
                <li>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
                    </div>
                </li>
            </ul>

            <ul class="right-menu">
                <li><a class="btn btn-light"><i class="fa fa-user"></i> войти</a></li>
            </ul>
        </nav>
    </header>
    <main>
        @yield('base-content')
    </main>
    <footer> &copy; 2025-2026</footer>
</body>
</html>
