@props([
    'title' => config('app.name', 'Base'),
    'breadcrumbs' => [],
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
   
    <link rel="icon" href="https://www.enegence.com.mx/img/logo-150x150.png" type="image/png" />
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

    <script>
        window.activeStoreId = @json(session('active_store_id'));
        window.userIsSuperUsuario = @json(auth()->check() && auth()->user()->hasRole('SuperUsuario'));
    </script>
</head>

<body class="font-sans antialiased bg-gray-100">

    @include('layouts.includes.admin.navigation')
    @include('layouts.includes.admin.sidebar')

    <div class="p-4 sm:ml-64 mb-20">
        
        <div class="mt-14 flex items-center">
            @include('layouts.includes.admin.breadcrumbs')

            @isset($action)
                <div class="ml-auto">
                    {{ $action }}
                </div>
            @endisset
        </div>

        {{ $slot }}
    </div>

    @stack('modals')


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

    <script>
        // Confirmación para formularios con clase .delete-form
        document.addEventListener('DOMContentLoaded', () => {
            const forms = document.querySelectorAll('.delete-form');
            forms.forEach((form) => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "¿Estás seguro?",
                        text: "¡No podrás revertir esto!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, eliminar"
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });
        });

    </script>

    @stack('scripts')

    @stack('js')
</body>

</html>
