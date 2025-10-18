{{-- resources/views/products/index.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Katalog Produk</h1>
            <p class="text-gray-600 mt-2">Temukan produk beauty care berkualitas dengan harga terjangkau</p>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap gap-4">
                <select name="category" class="rounded-lg border-gray-300 flex-1 min-w-[150px]">
                    <option value="">Semua Kategori</option>
                    <option value="skincare" {{ request('category') == 'skincare' ? 'selected' : '' }}>Skincare</option>
                    <option value="makeup" {{ request('category') == 'makeup' ? 'selected' : '' }}>Makeup</option>
                    <option value="tools" {{ request('category') == 'tools' ? 'selected' : '' }}>Tools</option>
                    <option value="fragrance" {{ request('category') == 'fragrance' ? 'selected' : '' }}>Fragrance</option>
                </select>

                <select name="condition" class="rounded-lg border-gray-300 flex-1 min-w-[150px]">
                    <option value="">Semua Kondisi</option>
                    <option value="like_new" {{ request('condition') == 'like_new' ? 'selected' : '' }}>Seperti Baru</option>
                    <option value="good" {{ request('condition') == 'good' ? 'selected' : '' }}>Baik</option>
                    <option value="fair" {{ request('condition') == 'fair' ? 'selected' : '' }}>Cukup Baik</option>
                </select>

                <button type="submit" class="bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700 transition">
                    Filter
                </button>
                <a href="{{ route('products.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">
                    Reset
                </a>
            </form>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @forelse($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <a href="{{ route('products.show', $product) }}">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-56 object-cover">
                    </a>
                    <div class="p-4">
                        <span class="text-xs text-gray-500 uppercase">{{ $product->category_label }}</span>
                        <h3 class="font-semibold text-lg mb-2 truncate">
                            <a href="{{ route('products.show', $product) }}" class="hover:text-pink-600">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description, 60) }}</p>
                        
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-2xl font-bold text-pink-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">{{ $product->condition_label }}</span>
                        </div>

                        <div class="flex items-center justify-between text-sm text-gray-600 mb-3">
                            <span>Stok: {{ $product->stock }}</span>
                        </div>

                        <a href="{{ route('products.show', $product) }}" class="block w-full text-center bg-pink-600 text-white py-2 rounded-lg hover:bg-pink-700 transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-6xl mb-4">🔍</div>
                    <p class="text-gray-500 text-lg">Tidak ada produk ditemukan</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mb-8">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>