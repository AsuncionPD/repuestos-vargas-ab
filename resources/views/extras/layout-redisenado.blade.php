<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Repuestos Vargas</title>

    <!-- Tipografía del nuevo diseño -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Swiper -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('wrench.png') }}">

    @include('extras.partials.posthog-meta')
    @vite(['resources/js/analytics.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            left: 0;
            bottom: -6px;
            background: #EA580C;
            transition: width .3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .mobile-menu-open {
            right: 0 !important;
        }
    </style>
</head>

<body class="m-0 flex min-h-screen flex-col overflow-x-hidden bg-white text-[#174765]">

    <!-- TOPBAR: se conservan los datos y redes del navegador original -->
    <div class="bg-[#ECF3FA] px-4 py-3 text-xs text-[#174765] sm:text-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <i class="fas fa-phone text-[#EA580C]" aria-hidden="true"></i>
                    <span>6039-1515</span>
                </div>

                <div class="hidden items-center gap-2 md:flex">
                    <i class="fas fa-envelope text-[#EA580C]" aria-hidden="true"></i>
                    <span>repuestosvargas28@outlook.com</span>
                </div>
            </div>

            <div class="flex items-center gap-4 text-lg">
                <a href="https://www.facebook.com/share/1AFsUdDnCA/?mibextid=wwXIfr"
                   target="_blank" rel="noopener noreferrer"
                   aria-label="Facebook de Repuestos Vargas"
                   class="transition hover:text-[#EA580C]">
                    <i class="fab fa-facebook" aria-hidden="true"></i>
                </a>

                <a href="https://www.instagram.com/repuestosvargas_28?igsh=MTI5OXp1OW9ydjcyMw=="
                   target="_blank" rel="noopener noreferrer"
                   aria-label="Instagram de Repuestos Vargas"
                   class="transition hover:text-[#EA580C]">
                    <i class="fab fa-instagram" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- NAVBAR: nuevo diseño visual con las funcionalidades originales -->
    <header class="sticky top-0 z-50 border-b border-gray-100 bg-white/95 shadow-[0_8px_30px_rgb(0,0,0,0.06)] backdrop-blur-md">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-4 sm:px-8">

            <!-- LOGO -->
            <a href="{{ route('extras.home') }}" class="flex min-w-0 shrink-0 items-center gap-2">
                <img
                    src="https://i.ibb.co/0VG5HSH8/logo-original-15.png"
                    alt="Logo de Repuestos Vargas"
                    class="h-10 w-10 object-contain sm:h-12 sm:w-12"
                >
                <span class="whitespace-nowrap text-lg font-bold sm:text-2xl">
                    <span class="text-[#154360]">Repuestos</span>
                    <span class="text-[#EA580C]">Vargas</span>
                </span>
            </a>

            <!-- NAV DESKTOP -->
            <nav class="hidden items-center gap-5 text-sm font-semibold xl:flex">
                <a href="{{ route('extras.home') }}"
                   class="nav-link transition hover:text-[#EA580C]">
                    Inicio
                </a>

                <a href="{{ route('products.home') }}"
                   data-ab-navigation="productos"
                   data-ab-navigation-type="productos"
                   data-ab-navigation-location="desktop"
                   class="nav-link transition hover:text-[#EA580C]">
                    Productos
                </a>

                <a href="{{ route('extras.home') }}#categorias"
                   data-ab-navigation="categorias"
                   data-ab-navigation-type="categorias"
                   data-ab-navigation-location="desktop"
                   class="nav-link transition hover:text-[#EA580C]">
                    Categorías
                </a>

                <a href="{{ route('extras.home') }}#contacto"
                   class="nav-link transition hover:text-[#EA580C]">
                    Contacto
                </a>

                @if(Auth::check() && Auth::user()->role == 'admin')
                    <a href="{{ route('auth.dashboard') }}"
                       class="nav-link transition hover:text-[#EA580C]">
                        Administración
                    </a>
                @endif
            </nav>

            <!-- ACCIONES DE CUENTA -->
            <div class="flex shrink-0 items-center gap-3">
                @guest
                    <a href="{{ route('login') }}"
                       class="hidden items-center gap-2 rounded-xl bg-[#174765] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#10364D] sm:flex">
                        <i class="fas fa-user" aria-hidden="true"></i>
                        Iniciar sesión
                    </a>
                @endguest

                @auth
                    <!-- MENÚ DE USUARIO DESKTOP -->
                    <div class="relative hidden lg:block">
                        <button
                            id="user-menu-btn"
                            type="button"
                            aria-label="Abrir menú de usuario"
                            aria-expanded="false"
                            aria-controls="user-menu"
                            class="flex h-11 w-11 items-center justify-center rounded-full bg-[#EA580C] text-white shadow-md transition hover:scale-105"
                        >
                            <i class="fas fa-user" aria-hidden="true"></i>
                        </button>

                        <div id="user-menu"
                             class="absolute right-0 mt-3 hidden w-60 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-2xl">
                            <div class="border-b border-gray-100 p-4">
                                <p class="truncate font-semibold text-[#174765]">
                                    {{ Auth::user()->name }}
                                </p>
                                <p class="truncate text-sm text-gray-500">
                                    {{ Auth::user()->email }}
                                </p>
                            </div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="w-full px-4 py-3 text-left text-sm text-red-500 transition hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2" aria-hidden="true"></i>
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                <!-- BOTÓN MENÚ MÓVIL -->
                <button
                    id="menu-btn"
                    type="button"
                    aria-label="Abrir menú"
                    aria-expanded="false"
                    aria-controls="mobile-menu"
                    class="flex h-11 w-11 items-center justify-center rounded-lg text-2xl text-[#174765] transition hover:bg-[#ECF3FA] focus:outline-none focus:ring-2 focus:ring-[#EA580C] xl:hidden"
                >
                    <i id="menu-open-icon" class="fas fa-bars" aria-hidden="true"></i>
                    <i id="menu-close-icon" class="fas fa-times hidden" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- MENÚ MÓVIL -->
    <div id="mobile-menu"
         class="fixed right-[-100%] top-0 z-[60] h-full w-[85%] max-w-[340px] overflow-y-auto border-l border-gray-100 bg-white shadow-2xl transition-all duration-300 ease-in-out">

        <div class="flex items-center justify-between border-b border-gray-100 bg-[#ECF3FA] p-5">
            <span class="text-xl font-bold text-[#174765]">Menú</span>
            <button id="close-menu" type="button" aria-label="Cerrar menú"
                    class="flex h-10 w-10 items-center justify-center rounded-lg text-xl text-[#174765] transition hover:bg-white">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>

        @auth
            <div class="border-b border-gray-100 bg-gray-50 px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#EA580C] text-lg text-white shadow-md">
                        <i class="fas fa-user" aria-hidden="true"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="truncate font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="truncate text-sm text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
        @endauth

        <nav class="flex flex-col gap-1 p-5 text-sm font-semibold">
            <a href="{{ route('extras.home') }}"
               class="flex items-center gap-3 rounded-lg px-4 py-3 transition hover:bg-[#ECF3FA] hover:text-[#EA580C]">
                <i class="fas fa-house w-5" aria-hidden="true"></i>
                Inicio
            </a>

            <a href="{{ route('products.home') }}"
               data-ab-navigation="productos"
               data-ab-navigation-type="productos"
               data-ab-navigation-location="mobile"
               class="flex items-center gap-3 rounded-lg px-4 py-3 transition hover:bg-[#ECF3FA] hover:text-[#EA580C]">
                <i class="fas fa-box w-5" aria-hidden="true"></i>
                Productos
            </a>

            <a href="{{ route('extras.home') }}#categorias"
               data-ab-navigation="categorias"
               data-ab-navigation-type="categorias"
               data-ab-navigation-location="mobile"
               class="flex items-center gap-3 rounded-lg px-4 py-3 transition hover:bg-[#ECF3FA] hover:text-[#EA580C]">
                <i class="fas fa-list w-5" aria-hidden="true"></i>
                Categorías
            </a>

            <a href="{{ route('extras.home') }}#contacto"
               class="flex items-center gap-3 rounded-lg px-4 py-3 transition hover:bg-[#ECF3FA] hover:text-[#EA580C]">
                <i class="fas fa-phone w-5" aria-hidden="true"></i>
                Contacto
            </a>

            @if(Auth::check() && Auth::user()->role == 'admin')
                <a href="{{ route('auth.dashboard') }}"
                   class="flex items-center gap-3 rounded-lg px-4 py-3 transition hover:bg-[#ECF3FA] hover:text-[#EA580C]">
                    <i class="fas fa-lock w-5" aria-hidden="true"></i>
                    Administración
                </a>
            @endif

            @guest
                <a href="{{ route('login') }}"
                   class="mt-3 flex items-center justify-center gap-2 rounded-xl bg-[#174765] px-4 py-3 text-white transition hover:bg-[#10364D]">
                    <i class="fas fa-user" aria-hidden="true"></i>
                    Iniciar sesión
                </a>
            @endguest

            @auth
                <form action="{{ route('logout') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit"
                            class="w-full rounded-xl bg-red-50 px-4 py-3 font-semibold text-red-500 transition hover:bg-red-100">
                        <i class="fas fa-sign-out-alt mr-2" aria-hidden="true"></i>
                        Cerrar sesión
                    </button>
                </form>
            @endauth
        </nav>
    </div>

    <!-- FONDO DEL MENÚ MÓVIL -->
    <div id="overlay"
         class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm"
         aria-hidden="true"></div>

    <!-- CONTENIDO -->
    <main class="mx-auto w-full max-w-7xl flex-grow px-3 py-5 sm:px-4 sm:py-8">
        @yield('content')
    </main>

    <!-- FOOTER ORIGINAL -->
    <footer id="contacto" class="mt-20 bg-[#174765] text-white">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-6 py-14 text-center md:grid-cols-3 md:gap-10 md:text-left">

            <!-- MARCA -->
            <div>
                <div class="mb-4 flex items-center justify-center gap-3 md:justify-start">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EA580C] shadow-lg">
                        <i class="fas fa-wrench text-2xl" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold sm:text-2xl">Repuestos Vargas</h2>
                        <p class="text-sm text-gray-300">Calidad y confianza</p>
                    </div>
                </div>
                <p class="text-sm leading-relaxed text-gray-300 sm:text-base">
                    Encuentra repuestos confiables y atención personalizada
                    para tu vehículo.
                </p>
            </div>

            <!-- CONTACTO -->
            <div>
                <h3 class="mb-5 text-xl font-bold text-orange-400">Contáctanos</h3>
                <div class="space-y-4 text-sm text-gray-300 sm:text-base">
                    <p class="flex items-center justify-center gap-3 md:justify-start">
                        <i class="fas fa-phone text-orange-400" aria-hidden="true"></i>
                        6039-1515
                    </p>
                    <p class="flex items-center justify-center gap-3 md:justify-start">
                        <i class="fas fa-envelope text-orange-400" aria-hidden="true"></i>
                        repuestosvargas28@outlook.com
                    </p>
                    <p class="flex items-start justify-center gap-3 md:justify-start">
                        <i class="fas fa-location-dot mt-1 text-orange-400" aria-hidden="true"></i>
                        <span>Alajuela Centro, frente a fábrica de hielo Mazú.</span>
                    </p>
                    <a href="https://maps.app.goo.gl/gib47BRYtDMCTwXZ6"
                       target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 text-orange-300 transition hover:text-orange-400">
                        Ver ubicación
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <!-- REDES -->
            <div>
                <h3 class="mb-5 text-xl font-bold text-orange-400">Síguenos</h3>
                <div class="flex justify-center gap-4 text-2xl md:justify-start">
                    <a href="https://www.facebook.com/share/1AFsUdDnCA/?mibextid=wwXIfr"
                       target="_blank" rel="noopener noreferrer"
                       aria-label="Facebook"
                       class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 transition hover:bg-[#EA580C]">
                        <i class="fab fa-facebook-f" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.instagram.com/repuestosvargas_28?igsh=MTI5OXp1OW9ydjcyMw=="
                       target="_blank" rel="noopener noreferrer"
                       aria-label="Instagram"
                       class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 transition hover:bg-[#EA580C]">
                        <i class="fab fa-instagram" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-white/10 py-5 text-center text-xs text-gray-300 sm:text-sm">
            © 2026 Repuestos Vargas — Todos los derechos reservados.
        </div>
    </footer>

    <!-- SCRIPTS DEL NAVEGADOR -->
    <script>
        (() => {
            // Menú de usuario en escritorio
            const userMenuBtn = document.getElementById('user-menu-btn');
            const userMenu = document.getElementById('user-menu');

            if (userMenuBtn && userMenu) {
                userMenuBtn.addEventListener('click', (event) => {
                    event.stopPropagation();
                    const isOpen = !userMenu.classList.contains('hidden');
                    userMenu.classList.toggle('hidden');
                    userMenuBtn.setAttribute('aria-expanded', String(!isOpen));
                });

                document.addEventListener('click', (event) => {
                    if (!userMenu.contains(event.target) && !userMenuBtn.contains(event.target)) {
                        userMenu.classList.add('hidden');
                        userMenuBtn.setAttribute('aria-expanded', 'false');
                    }
                });
            }

            // Menú móvil
            const menuBtn = document.getElementById('menu-btn');
            const closeMenuBtn = document.getElementById('close-menu');
            const mobileMenu = document.getElementById('mobile-menu');
            const overlay = document.getElementById('overlay');
            const openIcon = document.getElementById('menu-open-icon');
            const closeIcon = document.getElementById('menu-close-icon');

            if (!menuBtn || !closeMenuBtn || !mobileMenu || !overlay) return;

            function openMobileMenu() {
                mobileMenu.classList.add('mobile-menu-open');
                overlay.classList.remove('hidden');
                menuBtn.setAttribute('aria-expanded', 'true');
                menuBtn.setAttribute('aria-label', 'Cerrar menú');
                if (openIcon) openIcon.classList.add('hidden');
                if (closeIcon) closeIcon.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeMobileMenu() {
                mobileMenu.classList.remove('mobile-menu-open');
                overlay.classList.add('hidden');
                menuBtn.setAttribute('aria-expanded', 'false');
                menuBtn.setAttribute('aria-label', 'Abrir menú');
                if (openIcon) openIcon.classList.remove('hidden');
                if (closeIcon) closeIcon.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            menuBtn.addEventListener('click', () => {
                const isOpen = menuBtn.getAttribute('aria-expanded') === 'true';
                if (isOpen) {
                    closeMobileMenu();
                } else {
                    openMobileMenu();
                }
            });

            closeMenuBtn.addEventListener('click', closeMobileMenu);
            overlay.addEventListener('click', closeMobileMenu);

            mobileMenu.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', closeMobileMenu);
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') closeMobileMenu();
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1280) closeMobileMenu();
            });
        })();
    </script>
</body>
</html>
