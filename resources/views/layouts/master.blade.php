<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang Web')</title>
    
    @vite('resources/css/app.css')
</head>
<body>

    @include('components.navbar')

    <main class="container">
        @yield('content')
    </main>

    @include('components.footer')

    @stack('scripts')
</body>
</html>
