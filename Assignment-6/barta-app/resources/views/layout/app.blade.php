<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="{{ asset('assets/logo/logo.png') }}" type="image/x-icon">
    <title>@yield('title') | Barta</title>
     @include('layout.head')
</head>
<body class="bg-gray-100">

    <header>
        <!-- Navigation -->
        @include('layout.nav')
    </header>

    @yield('content')

    @include('layout.footer')
</body>
</html>
