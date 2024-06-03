<header class="grid grid-cols-2 items-center lg:grid-cols-2 dark:bg-gray-800">
    <div class="flex lg:justify-center lg:col-start-1 imgs">
        <a href="/">
            <img src="{{ asset('img/horizontal-logo-claro2.png') }}" alt="" class="h-16 w-auto">
        </a>
    </div>
    @if (Route::has('login'))
        <nav class="flex items-center links text-gray-900 dark:text-white">
            <div class="flex items-center login">
                <a href="{{ route('about') }}"
                    class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    Quienes somos
                </a>
                <a href="{{ route('contact.index') }}" class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">Contactar</a>
            </div>
            @auth
                <a href="{{ url('/dashboard') }}"
                    class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    Inicio
                </a>
            @else
                <div class="flex items-center login">
                    <p class="text-gray-900 dark:text-white">¿Ya tienes una cuenta?</p>
                    <a href="{{ route('login') }}"
                        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Log in
                    </a>
                </div>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Register
                    </a>
                @endif
            @endauth
        </nav>
    @endif
</header>