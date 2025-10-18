{{-- resources/views/cart/index.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Keranjang Belanja</h1>

        @if($carts->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <div class="text-6xl mb-4">🛒</div>
                <p class="text-gray-500 text-lg mb-6">Keranjang belanja Anda kosong</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700 transition">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($carts as $cart)
                        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col sm:flex-row gap-4">
                            <img src="{{ $cart->product->image_url }}" alt="{{ $cart->product->name }}" 
                                class="w-full sm:w-24 h-24 object-cover rounded">
                            
                            <div class="flex-1">
                                <h3 class="font-semibold text-lg mb-1">{{ $cart->product->name }}</h3>
                                <p class="text-gray-500 text-sm mb-2">{{ $cart->product->category_label }}</p>
                                <p class="text-pink-600 font-bold">Rp {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                            </div>

                            <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-start gap-4">
                                <!-- Quantity Form -->
                                <form action="{{ route('cart.update', $cart) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <label class="text-sm text-gray-600 sm:hidden">Qty:</label>
                                    <input type="number" name="quantity" value="{{ $cart->quantity }}" 
                                        min="1" max="{{ $cart->product->stock }}"
                                        class="w-16 rounded border-gray-300 text-center"
                                        onchange="this.form.submit()">
                                </form>

                                <!-- Subtotal -->
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Subtotal</p>
                                    <p class="font-bold text-lg">Rp {{ number_format($cart->subtotal, 0, ',', '.') }}</p>
                                </div>

                                <!-- Delete Button -->
                                <form action="{{ route('cart.destroy', $cart) }}" method="POST" 
                                    onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                        <h2 class="text-xl font-bold mb-4">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Total Item</span>
                                <span>{{ $carts->sum('quantity') }} produk</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t pt-3 flex justify-between font-bold text-lg">
                                <span>Total</span>
                                <span class="text-pink-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="block w-full bg-pink-600 text-white text-center py-3 rounded-lg hover:bg-pink-700 transition font-semibold">
                            Lanjut ke Pembayaran
                        </a>

                        <a href="{{ route('products.index') }}" class="block w-full text-center text-pink-600 hover:text-pink-700 mt-3">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>