@extends('extras.layout')

@section('title', 'Inicio')

@section('content')

<!-- Header con fondo completo -->
<div class="relative w-full h-auto bg-gradient-to-r from-[#1a5276] to-[#154360] flex items-center">
    <div class="absolute inset-0 z-10 bg-gradient-to-r from-[#2471a3] to-[#1b4f72] opacity-30"></div>

    <!-- Contenedor principal con layout responsivo en dos columnas -->
    <div class="relative z-20 w-full max-w-6xl mx-auto flex flex-col md:flex-row items-center px-8 py-8">
        <!-- Logo alineado arriba en móviles y a la izquierda en pantallas grandes -->
        <div class="w-full md:w-1/2 flex justify-center md:justify-start mb-8 md:mb-0">
            <img src="https://i.ibb.co/1NTjtBR/upscalemedia-transformed-removebg.png"
                alt="Logo"
                class="w-96 h-96 object-contain transition duration-300 hover:scale-105">
        </div>

        <!-- Contenido alineado al centro -->
        <div class="w-full md:w-1/2 text-white text-center flex flex-col items-center justify-center">
            <h2 class="text-5xl font-extrabold animate__animated animate__fadeIn animate__delay-1s">Navega por nuestra</h2>
            <h3 class="text-6xl font-extrabold mt-4 text-orange-300">TIENDA</h3>
            <p class="mt-2 text-lg font-medium">Soluciones a tu alcance, calidad y durabilidad garantizada.</p>

            <div class="mt-4">
                <a href="{{ route('products.home') }}"
                    class="inline-block px-6 py-2 text-lg font-semibold text-white bg-orange-500 border-2 border-orange-500 rounded-lg shadow-md transition-all duration-300 ease-in-out hover:bg-orange-600 hover:border-orange-600 hover:shadow-lg active:scale-95">
                    Ver todo
                </a>
            </div>
        </div>

    </div>
</div>


<!-- Sección de Categorías con iconos -->
<div id="categorias" class="px-4 sm:px-8 mt-12">
    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-4 sm:mb-0">Categorías</h2>
    </div>

    @php
        $icons = ['fa-cogs', 'fa-wrench', 'fa-tools', 'fa-screwdriver', 'fa-cube'];
    @endphp

    <!-- Carrusel horizontal solo en mobile -->
    <div class="sm:hidden overflow-x-auto">
        <div class="flex gap-4 px-1">
            @foreach ($categories as $category)
                @php $randomIcon = $icons[array_rand($icons)]; @endphp
                <div class="min-w-[250px] bg-white p-4 rounded-xl shadow-lg hover:scale-105 transition-transform duration-300 hover:shadow-2xl cursor-pointer text-center"
                     onclick="window.location='{{ route('products.byCategory', $category->id) }}'">
                    <div class="flex justify-center mb-4 text-orange-600 text-4xl">
                        <i class="fas {{ $randomIcon }}"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#1a5276]">{{ $category->name }}</h3>
                    <p class="text-gray-600 text-sm">{{ $category->description }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Grid normal para pantallas grandes -->
    <div class="hidden sm:grid grid-cols-2 lg:grid-cols-3 gap-10 px-2 sm:px-8">
        @foreach ($categories as $category)
            @php $randomIcon = $icons[array_rand($icons)]; @endphp
            <div class="relative group bg-white p-6 rounded-xl shadow-lg hover:scale-105 transition-transform duration-300 hover:shadow-2xl cursor-pointer text-center"
                 onclick="window.location='{{ route('products.byCategory', $category->id) }}'">
                <div class="flex justify-center mb-4 text-orange-600 text-4xl">
                    <i class="fas {{ $randomIcon }}"></i>
                </div>
                <h3 class="text-xl font-bold text-[#1a5276]">{{ $category->name }}</h3>
                <p class="text-gray-600">{{ $category->description }}</p>
            </div>
        @endforeach
    </div>
</div>



<!-- Sección Historia de la Empresa -->
<div class="relative w-full py-16 bg-gradient-to-r from-gray-50 to-gray-200 rounded-2xl mt-12 shadow-xl overflow-hidden">
    <!-- Figuras decorativas -->
    <div class="absolute top-5 left-10 w-24 h-24 bg-orange-500 opacity-10 rounded-full"></div>
    <div class="absolute bottom-5 right-10 w-32 h-32 bg-orange-400 opacity-10 rounded-full"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-56 h-56 bg-orange-500 opacity-10 rounded-full"></div>

    <div class="relative z-10 text-center px-8">
        <!-- Título elegante -->
        <h2 class="text-4xl font-extrabold text-gray-800 mb-4">¿Quienes somos?</h2>
        
        <!-- Línea decorativa -->
        <div class="w-24 h-1 mx-auto bg-[#1a5276] rounded-full mb-6"></div>

        <!-- Contenido de la historia -->
        <p class="text-lg text-gray-700 leading-relaxed max-w-3xl mx-auto">
            Desde nuestros inicios, nos hemos dedicado a ofrecer <span class="font-bold text-[#1a5276]">productos de calidad</span> y un
            <span class="font-bold text-[#1a5276]">servicio excepcional</span> a nuestros clientes. Respaldados por años de experiencia en repuestos y reparación.
        </p>

        <p class="text-lg text-gray-700 leading-relaxed max-w-3xl mx-auto mt-4">
            Cada producto que ofrecemos es seleccionado con <span class="font-bold text-[#1a5276]0">dedicación</span> para garantizar
            la mejor experiencia. Seguimos creciendo con <span class="font-bold text-[#1a5276]">calidad y compromiso.</span>
        </p>
    </div>
</div>

@endsection


