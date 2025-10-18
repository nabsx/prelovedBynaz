{{-- resources/views/products/show.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">
                <!-- Product Image -->
                <div class="md:w-1/2">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-96 md:h-full object-cover">
                </div>

                <!-- Product Info -->
                <div class="md:w-1/2 p-6 md:p-8">
                    <span class="text-sm text-gray-500 uppercase">{{ $product->category_label }}</span>
                    <h1 class="text-3xl font-bold text-gray-800 mt-2 mb-4">{{ $product->name }}</h1>

                    <div class="flex items-center gap-4 mb-6">
                        <span class="text-4xl font-bold text-pink-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">{{ $product->condition_label }}</span>
                    </div>

                    <div class="mb-6">
                        <h2 class="font-semibold text-lg mb-2">Deskripsi Produk</h2>
                        <p class="text-gray-600 whitespace-pre-line">{{ $product->description }}</p>
                    </div>

                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Kategori:</span>
                                <span class="font-semibold ml-2">{{ $product->category_label }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Kondisi:</span>
                                <span class="font-semibold ml-2">{{ $product->condition_label }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Stok:</span>
                                <span class="font-semibold ml-2">{{ $product->stock }} unit</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Status:</span>
                                <span class="font-semibold ml-2">
                                    @if($product->isInStock())
                                        <span class="text-green-600">Tersedia</span>
                                    @else
                                        <span class="text-red-600">Habis</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    @auth
                        @if(auth()->user()->isUser())
                            @if($product->isInStock())
                                <form action="{{ route('cart.store') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                            class="w-full md:w-32 rounded-lg border-gray-300">
                                    </div>

                                    <button type="submit" class="w-full bg-pink-600 text-white py-3 rounded-lg hover:bg-pink-700 transition font-semibold">
                                        🛒 Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                                    Maaf, produk ini sedang habis
                                </div>
                            @endif
                        @endif
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg">
                            <a href="{{ route('login') }}" class="font-semibold underline">Login</a> untuk membeli produk ini
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('products.index') }}" class="inline-flex items-center text-pink-600 hover:text-pink-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Katalog
            </a>
        </div>
    </div>
</x-app-layout>