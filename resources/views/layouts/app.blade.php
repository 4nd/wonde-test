<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Wonde Tech Test</title>

    <!-- Fonts -->
    @vite('resources/css/app.css')

    @livewireStyles
</head>
<body>
<div class="grid place-items-center">
    @yield('content')
</div>
@livewireScripts
</body>
</html>
