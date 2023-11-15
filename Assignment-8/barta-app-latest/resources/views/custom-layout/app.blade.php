<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="{{ asset('assets/logo/logo.png') }}" type="image/x-icon">
    <title>@yield('title') | Barta</title>
     @include('custom-layout.head')
</head>
<body class="bg-gray-100">

    <header>
        <!-- Navigation -->
        @include('custom-layout.nav')
    </header>

    @yield('content')

    @include('custom-layout.footer')

    @yield('script')
</body>
</html>
