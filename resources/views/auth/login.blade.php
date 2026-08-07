<x-guest-layout>
    <div class="min-h-screen bg-slate-100 flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-5xl overflow-hidden bg-white rounded-2xl shadow-xl grid lg:grid-cols-2">

            {{-- Panel corporativo --}}
            <div class="hidden lg:flex relative bg-slate-950 text-white p-12 flex-col justify-between">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl"></div>
                </div>

                <div class="relative z-10">
                    <img
                        src="https://www.enegence.com.mx/img/enegence.png"
                        alt="Enegence"
                        class="max-w-[220px] h-auto object-contain brightness-0 invert"
                    >
                </div>

                <div class="relative z-10">
                    <span class="inline-flex items-center px-3 py-1 mb-5 text-xs font-semibold tracking-widest uppercase rounded-full bg-blue-500/15 text-blue-300 border border-blue-400/20">
                        Plataforma corporativa
                    </span>

                    <h1 class="text-4xl font-bold leading-tight">
                        Bienvenido al portal de Enegence
                    </h1>

                    <p class="mt-5 text-base leading-relaxed text-slate-300">
                        Accede de manera segura a las herramientas, servicios y recursos
                        disponibles para nuestros usuarios.
                    </p>
                </div>

                <div class="relative z-10 text-sm text-slate-400">
                    © {{ date('Y') }} Enegence. Todos los derechos reservados.
                </div>
            </div>

            {{-- Formulario --}}
            <div class="px-6 py-10 sm:px-12 lg:px-14 lg:py-14">
                <div class="lg:hidden flex justify-center mb-8">
                    <img
                        src="https://www.enegence.com.mx/img/enegence.png"
                        alt="Enegence"
                        class="max-w-[210px] h-auto object-contain"
                    >
                </div>

                <div class="mb-8">
                    <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                        Acceso corporativo
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-slate-900">
                        Iniciar sesión
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Ingresa tus credenciales para continuar.
                    </p>
                </div>

                <x-validation-errors class="mb-6" />

                @session('status')
                    <div class="mb-6 px-4 py-3 text-sm font-medium text-green-700 bg-green-50 border border-green-200 rounded-lg">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Correo --}}
                    <div>
                        <x-label
                            for="email"
                            value="Correo electrónico"
                            class="mb-2 text-sm font-semibold text-slate-700"
                        />

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <svg
                                    class="w-5 h-5 text-slate-400"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21.75 6.75v10.5A2.25 2.25 0 0119.5 19.5h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0l-8.69 5.52a2 2 0 01-2.12 0L2.25 6.75"
                                    />
                                </svg>
                            </div>

                            <x-input
                                id="email"
                                class="block w-full pl-12 pr-4 py-3 border-slate-300 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                type="email"
                                name="email"
                                :value="old('email')"
                                placeholder="usuario@empresa.com"
                                required
                                autofocus
                                autocomplete="username"
                            />
                        </div>
                    </div>

                    {{-- Contraseña --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <x-label
                                for="password"
                                value="Contraseña"
                                class="text-sm font-semibold text-slate-700"
                            />

                            @if (Route::has('password.request'))
                                <a
                                    href="{{ route('password.request') }}"
                                    class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline"
                                >
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <svg
                                    class="w-5 h-5 text-slate-400"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 00-9 0v3.75m-.75 0h10.5A2.25 2.25 0 0119.5 12.75v6A2.25 2.25 0 0117.25 21H6.75a2.25 2.25 0 01-2.25-2.25v-6a2.25 2.25 0 012.25-2.25z"
                                    />
                                </svg>
                            </div>

                            <x-input
                                id="password"
                                class="block w-full pl-12 pr-12 py-3 border-slate-300 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                type="password"
                                name="password"
                                placeholder="Ingresa tu contraseña"
                                required
                                autocomplete="current-password"
                            />

                            <button
                                type="button"
                                id="togglePassword"
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 hover:text-slate-700"
                                aria-label="Mostrar contraseña"
                            >
                                <svg
                                    id="eyeIcon"
                                    class="w-5 h-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Recordarme --}}
                    <div class="flex items-center">
                        <label for="remember_me" class="flex items-center cursor-pointer">
                            <x-checkbox
                                id="remember_me"
                                name="remember"
                                class="text-blue-600 border-slate-300 rounded focus:ring-blue-500"
                            />

                            <span class="ml-2 text-sm text-slate-600">
                                Mantener mi sesión iniciada
                            </span>
                        </label>
                    </div>

                    {{-- Botón --}}
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center px-5 py-3 text-sm font-semibold text-white transition bg-blue-700 border border-transparent rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        Iniciar sesión

                        <svg
                            class="w-4 h-4 ml-2"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                            />
                        </svg>
                    </button>
                </form>

                {{-- Registro --}}
                @if (Route::has('register'))
                    <div class="mt-8 pt-6 border-t border-slate-200 text-center">
                        <p class="text-sm text-slate-600">
                            ¿Aún no tienes una cuenta?

                            <a
                                href="{{ route('register') }}"
                                class="ml-1 font-semibold text-blue-700 hover:text-blue-900 hover:underline"
                            >
                                Registrar usuario
                            </a>
                        </p>
                    </div>
                @endif

                <p class="mt-8 text-center text-xs text-slate-400">
                    El acceso a esta plataforma está protegido. No compartas tus credenciales.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (!togglePassword || !passwordInput) {
                return;
            }

            togglePassword.addEventListener('click', function () {
                const isPassword = passwordInput.type === 'password';

                passwordInput.type = isPassword ? 'text' : 'password';

                togglePassword.setAttribute(
                    'aria-label',
                    isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña'
                );
            });
        });
    </script>
</x-guest-layout>