<!DOCTYPE html>
<html class="html h-full bg-white">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="{{ asset('assets/logo/logo.png') }}" type="image/x-icon">
    <title>@yield('title') | Barta</title>
    @include('auth.layout.head')
</head>
<body class="h-full">

@yield('content')

</body>
</html>
