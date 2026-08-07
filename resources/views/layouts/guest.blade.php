<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
  
    <link rel="icon" href="https://www.enegence.com.mx/img/logo-150x150.png" type="image/png" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Styles -->
    @livewireStyles
</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>

    @livewireScripts

       @if (session('swal'))
        <script>
            Swal.fire(@json(session('swal')))
        </script>
    @endif

    <script>
        Livewire.on('swal', (data) => {
            Swal.fire(
                data[0]
            )
        })
    </script>
</body>

</html>
