@props([
    'title' => config('app.name', 'Base'),
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
     <link rel="icon" href="https://changarrito.mx/assets/img/favicon.jpeg" type="image/jpeg">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire styles -->
    @livewireStyles

    <!-- Icon fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- App assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://kit.fontawesome.com/a6cbcfb503.js" crossorigin="anonymous"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Flowbite -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    <!-- WireUI -->
    <wireui:scripts />

    <style>
        [x-cloak] {
            display: none !important
        }
    </style>

    @stack('css')
</head>

<body class="font-sans antialiased bg-gray-100">
     @include('layouts.includes.admin.navigation')
    <br>
     <div class="p-4 sm:ml-64 mb-20">
        {{ $slot }}
    </div>
    @stack('modals')

    @livewireScripts
</body>

</html>
