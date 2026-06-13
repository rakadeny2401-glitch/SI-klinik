<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page_title ?? 'Login' }}</title>

    @vite(['resources/css/app.css'])
</head>
<body>

    @yield('content')

</body>
</html>