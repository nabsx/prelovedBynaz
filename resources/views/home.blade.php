{{-- resources/views/home.blade.php --}}
<x-app-layout>
    <div class="bg-gradient-to-br from-pink-50 via-purple-50 to-pink-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Hero Section -->
            <div class="relative bg-gradient-to-r from-pink-500 via-pink-600 to-purple-600 rounded-2xl shadow-2xl overflow-hidden mb-12">
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <div class="relative z-10 p-8 md:p-16">
                    <div class="max-w-3xl">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white leading-tight">
                            Beauty Care Second
                        </h1>
                        <p class="text-lg md:text-xl mb-8 text-pink-50">
                            ✨ Skincare & Kosmetik Bekas Berkualitas dengan Harga Terjangkau
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('products.index') }}" 
                                class="inline-flex items-center justify-center bg-white text-pink-600 px-8 py-4 rounded-xl font-semibold hover:bg-pink-50 transition-all transform hover:scale-105 shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Belanja Sekarang
                            </a>
                            @guest
                                <a href="{{ route('register') }}" 
                                    class="inline-flex items-center justify-center bg-purple-700 text-white px-8 py-4 rounded-xl font-semibold hover:bg-purple-800 transition-all transform hover:scale-105 shadow-lg">
                                    Daftar Gratis
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-white rounded-full opacity-10"></div>
                <div class="absolute bottom-0 right-0 -mb-32 -mr-32 w-96 h-96 bg-purple-400 rounded-full opacity-10"></div>
            </div>

            <!-- Featured Products -->
            <div class="mb-12">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Produk Terbaru</h2>
                        <p class="text-gray-600">Dapatkan produk beauty care terbaik dengan harga spesial</p>
                    </div>
                    <a href="{{ route('products.index') }}" class="hidden md:inline-flex items-center text-pink-600 hover:text-pink-700 font-semibold">
                        Lihat Semua
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                @php
                    $featuredProducts = \App\Models\Product::where('is_active', true)
                        ->where('stock', '>', 0)
                        ->latest()
                        ->take(8)
                        ->get();
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($featuredProducts as $product)
                        <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="relative overflow-hidden aspect-square">
                                <img src="{{ $product->image_url }}" 
                                    alt="{{ $product->name }}" 
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                
                                <!-- Overlay Badge -->
                                <div class="absolute top-3 left-3">
                                    <span class="bg-gradient-to-r from-pink-500 to-purple-500 text-white text-xs font-semibold px-3 py-1.5 rounded-full shadow-lg">
                                        {{ $product->condition_label }}
                                    </span>
                                </div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-3 right-3">
                                    <span class="bg-white/90 backdrop-blur-sm text-gray-700 text-xs font-medium px-3 py-1.5 rounded-full">
                                        {{ $product->category_label }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-5">
                                <h3 class="font-bold text-lg mb-2 text-gray-800 line-clamp-1 group-hover:text-pink-600 transition">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2 min-h-[40px]">
                                    {{ Str::limit($product->description, 60) }}
                                </p>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Harga</p>
                                        <p class="text-2xl font-bold text-pink-600">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500 mb-1">Stok</p>
                                        <p class="text-sm font-semibold text-gray-700">{{ $product->stock }} unit</p>
                                    </div>
                                </div>

                                <a href="{{ route('products.show', $product) }}" 
                                    class="block w-full text-center bg-gradient-to-r from-pink-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-pink-600 hover:to-purple-700 transition-all transform hover:scale-105 shadow-md">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-2xl shadow-md p-12 text-center">
                            <div class="text-6xl mb-4">🛍️</div>
                            <p class="text-gray-500 text-lg">Belum ada produk tersedia</p>
                        </div>
                    @endforelse
                </div>

                <!-- View All Button (Mobile) -->
                <div class="mt-8 text-center md:hidden">
                    <a href="{{ route('products.index') }}" 
                        class="inline-flex items-center text-pink-600 hover:text-pink-700 font-semibold">
                        Lihat Semua Produk
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Categories Section -->
            <div class="mb-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Kategori Produk</h2>
                    <p class="text-gray-600">Temukan produk sesuai kebutuhan Anda</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('products.index', ['category' => 'skincare']) }}" 
                        class="group bg-gradient-to-br from-pink-100 to-pink-200 hover:from-pink-200 hover:to-pink-300 p-8 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="text-center">
                            <div class="text-5xl mb-4 group-hover:scale-110 transition-transform">🧴</div>
                            <h3 class="font-bold text-lg text-gray-800">Skincare</h3>
                            <p class="text-sm text-gray-600 mt-1">Perawatan Kulit</p>
                        </div>
                    </a>

                    <a href="{{ route('products.index', ['category' => 'makeup']) }}" 
                        class="group bg-gradient-to-br from-purple-100 to-purple-200 hover:from-purple-200 hover:to-purple-300 p-8 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="text-center">
                            <div class="text-5xl mb-4 group-hover:scale-110 transition-transform">💄</div>
                            <h3 class="font-bold text-lg text-gray-800">Makeup</h3>
                            <p class="text-sm text-gray-600 mt-1">Kosmetik</p>
                        </div>
                    </a>

                    <a href="{{ route('products.index', ['category' => 'tools']) }}" 
                        class="group bg-gradient-to-br from-rose-100 to-rose-200 hover:from-rose-200 hover:to-rose-300 p-8 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="text-center">
                            <div class="text-5xl mb-4 group-hover:scale-110 transition-transform">🪮</div>
                            <h3 class="font-bold text-lg text-gray-800">Tools</h3>
                            <p class="text-sm text-gray-600 mt-1">Alat Kecantikan</p>
                        </div>
                    </a>

                    <a href="{{ route('products.index', ['category' => 'fragrance']) }}" 
                        class="group bg-gradient-to-br from-fuchsia-100 to-fuchsia-200 hover:from-fuchsia-200 hover:to-fuchsia-300 p-8 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="text-center">
                            <div class="text-5xl mb-4 group-hover:scale-110 transition-transform">🌸</div>
                            <h3 class="font-bold text-lg text-gray-800">Fragrance</h3>
                            <p class="text-sm text-gray-600 mt-1">Parfum</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Why Choose Us Section -->
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 mb-12">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Kenapa Memilih Kami?</h2>
                    <p class="text-gray-600">Belanja produk beauty care bekas dengan aman dan nyaman</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="bg-gradient-to-br from-pink-100 to-purple-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-2 text-gray-800">Produk Terjamin</h3>
                        <p class="text-gray-600">Semua produk sudah diverifikasi kualitasnya</p>
                    </div>

                    <div class="text-center">
                        <div class="bg-gradient-to-br from-pink-100 to-purple-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-2 text-gray-800">Harga Terjangkau</h3>
                        <p class="text-gray-600">Dapatkan produk branded dengan harga hemat</p>
                    </div>

                    <div class="text-center">
                        <div class="bg-gradient-to-br from-pink-100 to-purple-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-2 text-gray-800">Pembayaran Aman</h3>
                        <p class="text-gray-600">Transaksi dilindungi dengan sistem pembayaran Midtrans</p>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="bg-gradient-to-r from-pink-500 via-pink-600 to-purple-600 rounded-2xl shadow-2xl p-8 md:p-12 text-center text-white">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Siap Menemukan Beauty Care Favoritmu?</h2>
                <p class="text-lg md:text-xl mb-8 text-pink-50">Bergabunglah dengan ribuan pembeli yang puas!</p>
                <a href="{{ route('products.index') }}" 
                    class="inline-flex items-center bg-white text-pink-600 px-8 py-4 rounded-xl font-bold hover:bg-pink-50 transition-all transform hover:scale-105 shadow-lg text-lg">
                    Mulai Belanja Sekarang
                    <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>

