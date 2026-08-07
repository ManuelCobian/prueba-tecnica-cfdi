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
                        Registro corporativo
                    </span>

                    <h1 class="text-4xl font-bold leading-tight">
                        Crea tu cuenta de acceso
                    </h1>

                    <p class="mt-5 text-base leading-relaxed text-slate-300">
                        Registra tus datos para acceder de forma segura a las
                        herramientas y recursos de la organización.
                    </p>
                </div>

                <div class="relative z-10 text-sm text-slate-400">
                    © {{ date('Y') }} Enegence. Todos los derechos reservados.
                </div>
            </div>

            {{-- Formulario --}}
            <div class="px-6 py-10 sm:px-12 lg:px-14 lg:py-12">
                <div class="lg:hidden flex justify-center mb-8">
                    <img
                        src="https://www.enegence.com.mx/img/enegence.png"
                        alt="Enegence"
                        class="max-w-[210px] h-auto object-contain"
                    >
                </div>

                <div class="mb-7">
                    <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                        Alta de usuario
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-slate-900">
                        Crear una cuenta
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Completa la información solicitada para registrarte.
                    </p>
                </div>

                <x-validation-errors class="mb-6" />

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    {{-- Nombre --}}
                    <div>
                        <x-label
                            for="name"
                            value="Nombre completo"
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
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632z"
                                    />
                                </svg>
                            </div>

                            <x-input
                                id="name"
                                class="block w-full pl-12 pr-4 py-3 border-slate-300 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                type="text"
                                name="name"
                                :value="old('name')"
                                placeholder="Nombre y apellidos"
                                required
                                autofocus
                                autocomplete="name"
                            />
                        </div>
                    </div>

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
                                autocomplete="username"
                            />
                        </div>
                    </div>

                    {{-- Contraseña --}}
                    <div>
                        <x-label
                            for="password"
                            value="Contraseña"
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
                                        d="M16.5 10.5V6.75a4.5 4.5 0 00-9 0v3.75m-.75 0h10.5A2.25 2.25 0 0119.5 12.75v6A2.25 2.25 0 0117.25 21H6.75a2.25 2.25 0 01-2.25-2.25v-6a2.25 2.25 0 012.25-2.25z"
                                    />
                                </svg>
                            </div>

                            <x-input
                                id="password"
                                class="block w-full pl-12 pr-12 py-3 border-slate-300 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                type="password"
                                name="password"
                                placeholder="Crea una contraseña segura"
                                required
                                autocomplete="new-password"
                            />

                            <button
                                type="button"
                                data-password-toggle="password"
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 hover:text-slate-700"
                                aria-label="Mostrar contraseña"
                            >
                                <svg
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

                        <p class="mt-2 text-xs text-slate-500">
                            Utiliza al menos 8 caracteres.
                        </p>
                    </div>

                    {{-- Confirmar contraseña --}}
                    <div>
                        <x-label
                            for="password_confirmation"
                            value="Confirmar contraseña"
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
                                        d="M9 12.75L11.25 15 15 9.75m1.5.75V6.75a4.5 4.5 0 00-9 0v3.75m-.75 0h10.5A2.25 2.25 0 0119.5 12.75v6A2.25 2.25 0 0117.25 21H6.75a2.25 2.25 0 01-2.25-2.25v-6a2.25 2.25 0 012.25-2.25z"
                                    />
                                </svg>
                            </div>

                            <x-input
                                id="password_confirmation"
                                class="block w-full pl-12 pr-12 py-3 border-slate-300 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                type="password"
                                name="password_confirmation"
                                placeholder="Repite tu contraseña"
                                required
                                autocomplete="new-password"
                            />

                            <button
                                type="button"
                                data-password-toggle="password_confirmation"
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 hover:text-slate-700"
                                aria-label="Mostrar contraseña"
                            >
                                <svg
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

                    {{-- Términos y privacidad --}}
                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div>
                            <label for="terms" class="flex items-start cursor-pointer">
                                <x-checkbox
                                    name="terms"
                                    id="terms"
                                    required
                                    class="mt-1 text-blue-600 border-slate-300 rounded focus:ring-blue-500"
                                />

                                <span class="ms-3 text-sm leading-relaxed text-slate-600">
                                    Acepto los

                                    <a
                                        target="_blank"
                                        href="{{ route('terms.show') }}"
                                        class="font-semibold text-blue-700 hover:text-blue-900 hover:underline"
                                    >
                                        términos de servicio
                                    </a>

                                    y la

                                    <a
                                        target="_blank"
                                        href="{{ route('policy.show') }}"
                                        class="font-semibold text-blue-700 hover:text-blue-900 hover:underline"
                                    >
                                        política de privacidad
                                    </a>.
                                </span>
                            </label>
                        </div>
                    @endif

                    {{-- Botón --}}
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center px-5 py-3 text-sm font-semibold text-white transition bg-blue-700 border border-transparent rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        Registrar usuario

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
                                d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3M6.75 6.75a3 3 0 116 0 3 3 0 01-6 0zM3.375 20.25a6.375 6.375 0 0112.75 0v.75H3.375v-.75z"
                            />
                        </svg>
                    </button>
                </form>

                {{-- Volver al login --}}
                <div class="mt-7 pt-6 border-t border-slate-200 text-center">
                    <p class="text-sm text-slate-600">
                        ¿Ya tienes una cuenta?

                        <a
                            href="{{ route('login') }}"
                            class="ml-1 font-semibold text-blue-700 hover:text-blue-900 hover:underline"
                        >
                            Iniciar sesión
                        </a>
                    </p>
                </div>

                <p class="mt-7 text-center text-xs text-slate-400">
                    Tus datos serán utilizados exclusivamente para gestionar tu acceso a la plataforma.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButtons = document.querySelectorAll('[data-password-toggle]');

            toggleButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    const inputId = button.getAttribute('data-password-toggle');
                    const input = document.getElementById(inputId);

                    if (!input) {
                        return;
                    }

                    const isPassword = input.type === 'password';

                    input.type = isPassword ? 'text' : 'password';

                    button.setAttribute(
                        'aria-label',
                        isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña'
                    );
                });
            });
        });
    </script>
</x-guest-layout>