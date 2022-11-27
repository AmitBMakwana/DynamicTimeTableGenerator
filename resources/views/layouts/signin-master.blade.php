<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{ config('app.name', '') }}</title>
    <!-- Styles -->
    <link href="{{ asset('bootstrap/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/design.css') }}" rel="stylesheet" type="text/css">
    <!-- Scripts -->
    <script src="{{ asset('bootstrap/js/jquery.min.js') }}" ></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}" defer></script>
    @yield('style')
</head>

<body>
    @yield('content')
    @yield('script')
</body>

</html>