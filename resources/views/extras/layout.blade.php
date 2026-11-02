<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Repuestos Vargas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="icon" type="image/png" href="{{ asset('wrench.png') }}">
    <link rel="shortcut icon" href="{{ asset('wrench.png') }}" type="image/png">

    @include('extras.partials.posthog-meta')
    @vite(['resources/js/analytics.js'])

</head>

<body class="bg-gray-100 flex flex-col min-h-screen">

    <header class="bg-white p-4 shadow-md">
        <div class="container mx-auto flex items-center justify-between">
            <!-- Menú de usuario en móvil -->
            <div class="relative sm:static">
                <button id="user-menu-btn" class="sm:hidden text-gray-700 hover:text-[#1a5276] transition">
                    <i class="fas fa-user text-lg sm:text-xl"></i>
                </button>

                <!-- Menú desplegable para móviles -->
                <div id="user-menu"
                    class="hidden absolute left-0 top-full mt-1 bg-white shadow-lg rounded w-max min-w-[150px] p-2 text-center z-50">
                    @auth
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full text-gray-700 hover:bg-gray-100 px-3 py-2 rounded">
                                Cerrar sesión
                            </button>
                        </form>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="block text-gray-700 hover:bg-gray-100 px-3 py-2 rounded">
                            Iniciar sesión
                        </a>
                    @endguest
                </div>
            </div>


            <!-- Iniciar sesión en pantallas grandes -->
            <div class="hidden sm:flex items-center space-x-2">
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 transition hover:text-[#1a5276]">Cerrar sesión</button>
                    </form>
                    <a href="#" class="text-gray-700 transition hover:text-[#1a5276]">
                        <i class="fas fa-user text-lg sm:text-xl"></i>
                    </a>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-[#1a5276] transition font-semibold text-sm sm:text-base">Iniciar sesión</a>
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-[#1a5276] transition">
                        <i class="fas fa-user text-lg sm:text-xl"></i>
                    </a>
                @endguest
            </div>

            <!-- Nombre de la empresa centrado -->
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 text-center flex-grow">
                Repuestos <span class="text-orange-600">Vargas</span>
            </h1>

            <!-- Redes sociales -->
            <div class="flex space-x-3">
                <a href="https://www.facebook.com/share/1AFsUdDnCA/?mibextid=wwXIfr" class="text-gray-700 hover:text-[#1a5276] transition">
                    <i class="fab fa-facebook text-lg sm:text-xl"></i>
                </a>
                <a href="https://www.instagram.com/repuestosvargas_28?igsh=MTI5OXp1OW9ydjcyMw==" class="text-gray-700 hover:text-pink-500 transition">
                    <i class="fab fa-instagram text-lg sm:text-xl"></i>
                </a>
            </div>
        </div>

        <!-- Menú de navegación -->
        <nav class="bg-[#1a5276] p-3">
            <div class="container mx-auto flex flex-col sm:flex-row items-center justify-center">
                <!-- Menú normal en pantallas grandes -->
                <div class="hidden sm:flex space-x-6">
                    <a href="{{ route('extras.home') }}" class="text-white hover:text-orange-300 transition duration-300">Inicio</a>
                    <a href="{{ route('products.home') }}" data-ab-navigation="productos" data-ab-navigation-type="productos" data-ab-navigation-location="desktop" class="text-white hover:text-orange-300 transition duration-300">Productos</a>
                    <a href="{{ route('extras.home') }}#categorias" data-ab-navigation="categorias" data-ab-navigation-type="categorias" data-ab-navigation-location="desktop" class="text-white hover:text-orange-300 transition duration-300">Categorías</a>
                    <a href="#contacto" class="text-white hover:text-orange-300 transition duration-300">Contacto</a>
                    @if(Auth::check() && Auth::user()->role == 'admin')
                        <a href="{{ route('auth.dashboard') }}" class="text-white hover:text-orange-300 transition duration-300">Administración</a>
                    @endif
                </div>

                <!-- Botón de menú hamburguesa en móviles -->
                <button id="menu-btn" class="sm:hidden text-white focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Menú desplegable en móviles -->
            <div id="mobile-menu" class="hidden sm:hidden bg-[#1a5276] p-3 mt-2 text-center">
                <a href="{{ route('extras.home') }}" class="block text-white py-2 hover:text-orange-300 transition duration-300">Inicio</a>
                <a href="{{ route('products.home') }}" data-ab-navigation="productos" data-ab-navigation-type="productos" data-ab-navigation-location="mobile" class="block text-white py-2 hover:text-orange-300 transition duration-300">Productos</a>
                <a href="{{ route('extras.home') }}#categorias" data-ab-navigation="categorias" data-ab-navigation-type="categorias" data-ab-navigation-location="mobile" class="block text-white py-2 hover:text-orange-300 transition duration-300">Categorías</a>
                <a href="#contacto" class="block text-white py-2 hover:text-orange-300 transition duration-300">Contacto</a>
                @if(Auth::check() && Auth::user()->role == 'admin')
                    <a href="{{ route('auth.dashboard') }}" class="text-white hover:text-orange-300 transition duration-300">Administración</a>
                @endif
            </div>
        </nav>
    </header>


    <script>
        // Menú de usuario en móviles
        const userMenuBtn = document.getElementById('user-menu-btn');
        const userMenu = document.getElementById('user-menu');

        userMenuBtn.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (!userMenu.contains(event.target) && !userMenuBtn.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });

        // Menú hamburguesa en móviles
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>


    <!-- FontAwesome para los iconos -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>

    <main class="container mx-auto p-6 flex-grow">
        @yield('content')
    </main>

    <footer id="contacto" class="bg-[#1a5276] text-white py-10 mt-16">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
            
            <!-- Marca -->
            <div>
                <h2 class="text-2xl font-bold text-orange-500 mb-2">Repuestos Vargas</h2>
                <p class="text-sm text-gray-200">Calidad y confianza en cada repuesto.</p>
            </div>
    
            <!-- Contacto -->
            <div>
                <h3 class="text-lg font-semibold text-orange-400 mb-2">Contáctanos</h3>
                <ul class="space-y-2 text-sm">
                    <li>📞 <a href="tel:60391515" class="hover:text-orange-300 transition">6039-1515</a></li>
                    <li>✉️ <a href="mailto:repuestosvargas28@outlook.com" class="hover:text-orange-300 transition">repuestosvargas28@outlook.com</a></li>
                    <li class="flex items-start gap-2 mt-2">
                        <i class="fas fa-map-marker-alt mt-1 text-orange-400"></i>
                        <div>
                            <p class="text-gray-200">Alajuela Centro, del costado suroeste del mercado municipal 150 mts al Sur; frente a fábrica de hielo Mazú.</p>
                            <a href="https://maps.app.goo.gl/gib47BRYtDMCTwXZ6" target="_blank" class="text-orange-300 hover:underline text-sm">
                                Ver ubicación en Google Maps
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
    
            <!-- Redes sociales -->
            <div>
                <h3 class="text-lg font-semibold text-orange-400 mb-2">Síguenos</h3>
                <div class="flex justify-center md:justify-start space-x-4 text-2xl">
                    <a href="https://www.facebook.com/share/1AFsUdDnCA/?mibextid=wwXIfr" class="hover:text-orange-300 transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/repuestosvargas_28?igsh=MTI5OXp1OW9ydjcyMw==" class="hover:text-orange-300 transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    
        <!-- Derechos -->
        <div class="mt-10 text-center text-xs text-gray-300 border-t border-gray-600 pt-4">
            © 2025 Repuestos Vargas. Todos los derechos reservados.
        </div>
    </footer>






</body>
</html>
