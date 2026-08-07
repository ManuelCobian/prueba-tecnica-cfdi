<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">

            @foreach ($sidebarItems as $link)
                <li>
                    {!! $link->render() !!}
                </li>
            @endforeach

            <li class="pt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex items-center w-full px-3 py-2 text-black hover:bg-[#38414d] rounded-lg">
                        <i class="fa-solid fa-power-off w-6"></i>
                        <span class="ml-3">Cerrar sesión</span>
                    </button>
                </form>
            </li>

        </ul>
    </div>
</aside>
