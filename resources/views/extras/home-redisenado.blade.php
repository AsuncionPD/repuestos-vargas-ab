
@extends('extras.layout-redisenado')

@section('title', 'Inicio')

@section('content')

    {{-- Banner principal: nuevo diseño de home-copia.blade.php --}}
    <section class="relative flex flex-col items-center gap-10 overflow-hidden rounded-2xl bg-[#174765] px-6 py-12 sm:px-10 md:py-16 lg:flex-row lg:px-14 lg:py-20">

        <div class="w-full lg:w-1/2">
            <h1 class="text-4xl font-bold leading-tight text-white sm:text-5xl">
                Soluciones para
                <span class="text-[#EA580C]">tu hogar,</span>
                siempre a tu alcance
            </h1>

            <p class="mt-6 text-base font-light tracking-wide text-white sm:text-xl">
                REPUESTOS VARGAS
            </p>

            <p class="mt-4 max-w-xl text-base leading-relaxed text-white/90 sm:text-lg">
                Repuestos originales, calidad garantizada y el respaldo
                que necesitas para tus electrodomésticos.
            </p>

            <a href="{{ route('products.home') }}"
               data-ab-hero-cta="ver_todo"
               class="mt-8 inline-flex items-center gap-4 rounded-xl bg-[#EA580C] px-7 py-4 font-bold text-white transition hover:bg-[#c94b09] focus:outline-none focus:ring-2 focus:ring-white">
                Ver todo
                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M5 12h14m-7-7 7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="w-full lg:w-1/2">
            <img
                src="https://i.ibb.co/TxwsX3ny/appliances.png"
                alt="Catálogo de electrodomésticos y repuestos"
                class="mx-auto h-auto w-full max-w-xl object-contain"
                loading="eager"
            >
        </div>
    </section>

    {{-- Categorías: se conserva la información dinámica y sus rutas --}}
    <section id="categorias" class="mt-12 scroll-mt-24 px-1 sm:px-4">
        <div class="mb-6 flex flex-col items-center justify-between sm:flex-row">
            <h2 class="mb-4 text-3xl font-bold text-gray-800 sm:mb-0">Categorías</h2>
        </div>

        @php
            $icons = ['fa-cogs', 'fa-wrench', 'fa-tools', 'fa-screwdriver', 'fa-cube'];
        @endphp

        {{-- Carrusel horizontal para móviles --}}
        <div class="overflow-x-auto sm:hidden">
            <div class="flex gap-4 px-1 pb-4">
                @foreach ($categories as $category)
                    @php $randomIcon = $icons[array_rand($icons)]; @endphp
                    <a href="{{ route('products.byCategory', $category->id) }}"
                       class="min-w-[250px] cursor-pointer rounded-xl bg-white p-4 text-center shadow-lg transition-transform duration-300 hover:scale-105 hover:shadow-2xl">
                        <div class="mb-4 flex justify-center text-4xl text-[#EA580C]">
                            <i class="fas {{ $randomIcon }}" aria-hidden="true"></i>
                        </div>
                        <h3 class="text-lg font-bold text-[#174765]">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $category->description }}</p>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Grid para pantallas medianas y grandes --}}
        <div class="hidden grid-cols-2 gap-8 px-2 sm:grid lg:grid-cols-3 lg:gap-10 sm:px-4">
            @foreach ($categories as $category)
                @php $randomIcon = $icons[array_rand($icons)]; @endphp
                <a href="{{ route('products.byCategory', $category->id) }}"
                   class="group relative cursor-pointer rounded-xl bg-white p-6 text-center shadow-lg transition-transform duration-300 hover:scale-105 hover:shadow-2xl">
                    <div class="mb-4 flex justify-center text-4xl text-[#EA580C]">
                        <i class="fas {{ $randomIcon }}" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#174765]">{{ $category->name }}</h3>
                    <p class="text-gray-600">{{ $category->description }}</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Historia de la empresa: se conserva el contenido original --}}
    <section class="relative mt-12 w-full overflow-hidden rounded-2xl bg-gradient-to-r from-gray-50 to-gray-200 py-16 shadow-xl">
        <!-- Figuras decorativas -->
        <div class="absolute left-10 top-5 h-24 w-24 rounded-full bg-[#EA580C] opacity-10"></div>
        <div class="absolute bottom-5 right-10 h-32 w-32 rounded-full bg-orange-400 opacity-10"></div>
        <div class="absolute left-1/2 top-1/2 h-56 w-56 -translate-x-1/2 -translate-y-1/2 rounded-full bg-[#EA580C] opacity-10"></div>

        <div class="relative z-10 px-8 text-center">
            <h2 class="mb-4 text-4xl font-extrabold text-gray-800">¿Quiénes somos?</h2>

            <div class="mx-auto mb-6 h-1 w-24 rounded-full bg-[#174765]"></div>

            <p class="mx-auto max-w-3xl text-lg leading-relaxed text-gray-700">
                Desde nuestros inicios, nos hemos dedicado a ofrecer
                <span class="font-bold text-[#174765]">productos de calidad</span> y un
                <span class="font-bold text-[#174765]">servicio excepcional</span> a nuestros clientes.
                Respaldados por años de experiencia en repuestos y reparación.
            </p>

            <p class="mx-auto mt-4 max-w-3xl text-lg leading-relaxed text-gray-700">
                Cada producto que ofrecemos es seleccionado con
                <span class="font-bold text-[#174765]">dedicación</span> para garantizar
                la mejor experiencia. Seguimos creciendo con
                <span class="font-bold text-[#174765]">calidad y compromiso.</span>
            </p>
        </div>
    </section>

@endsection
