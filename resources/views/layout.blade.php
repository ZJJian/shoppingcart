<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link href="static/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
<header>
    <div class="content-wrapper">
        <h1>Shopping Cart System</h1>
        <div class="link-icons">
            <a href="{{ route('shop.cart')}}">
                <i class="fas fa-shopping-cart"></i>
                @if(Session::has('CARTCOUNT') && Session::get('CARTCOUNT') > 0)
                    <span>{{ json_encode(Session::get('CARTCOUNT'))}}</span>
                @endif
            </a>
        </div>
    </div>
</header>
<main>

    @yield('content')


    @yield('scripts')


</main>
<footer>
    <div class="content-wrapper">
        <p>&copy; 2022, Shopping Cart System</p>
    </div>
</footer>
<script src="static/js/script.js"></script>
</body>
</html>
