<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-white dark:bg-gray-700 text-[#1b1b18] flex p-6 lg:p-8 items-start lg:justify-start min-h-screen flex-col">
    
    <div class="container mt-10">
        @include('partials.aside')
        @yield('content')
    </div>

    <footer>
        <!-- Common footer -->
    </footer>

    @stack('scripts')
</body>

</html>