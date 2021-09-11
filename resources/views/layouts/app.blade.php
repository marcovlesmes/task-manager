<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Manager</title>
    <!-- script -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="bg-gray-800 text-gray-50 h-full">
    <div x-data="manager()" x-init="init()" class="container">
        @yield('content')
    </div>
</body>
<script src="{{ asset('js/manager.js') }}"></script>

</html>