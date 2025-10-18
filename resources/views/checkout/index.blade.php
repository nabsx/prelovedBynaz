{{-- resources/views/checkout/index.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Checkout</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Checkout Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4">Informasi Pengiriman</h2>
                    
                    <form id="checkout-form">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" value="{{ auth()->user()->name }}" readonly
                                    class="w-full rounded-lg border-gray-300 bg-gray-50">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" value="{{ auth()->user()->email }}" readonly
                                    class="w-full rounded-lg border-gray-300 bg-gray-50">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon <span class="text-red-600">*</span></label>
                                <input type="text" name="phone" id="phone" 
                                    value="{{ auth()->user()->phone }}" required
                                    class="w-full rounded-lg border-gray-300"
                                    placeholder="08xxxxxxxxxx">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap <span class="text-red-600">*</span></label>
                                <textarea name="address" id="address" rows="4" required
                                    class="w-full rounded-lg border-gray-300"
                                    placeholder="Masukkan alamat lengkap untuk pengiriman">{{ auth()->user()->address }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4">Produk yang Dibeli</h2>
                    <div class="space-y-4">
                        @foreach($carts as $cart)
                            <div class="flex gap-4 pb-4 border-b last:border-0">
                                <img src="{{ $cart->product->image_url }}" alt="{{ $cart->product->name }}" 
                                    class="w-16 h-16 object-cover rounded">
                                <div class="flex-1">
                                    <h3 class="font-semibold">{{ $cart->product->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $cart->quantity }} x Rp {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold">Rp {{ number_format($cart->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary & Payment -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                    <h2 class="text-xl font-bold mb-4">Ringkasan Pembayaran</h2>
                    
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
                            <span>Total Bayar</span>
                            <span class="text-pink-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="button" id="pay-button" 
                        class="w-full bg-pink-600 text-white py-3 rounded-lg hover:bg-pink-700 transition font-semibold">
                        Bayar Sekarang
                    </button>

                    <p class="text-xs text-gray-500 text-center mt-4">
                        Dengan melanjutkan, Anda menyetujui syarat dan ketentuan yang berlaku
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.getElementById('pay-button').addEventListener('click', function () {
            const phone = document.getElementById('phone').value;
            const address = document.getElementById('address').value;

            if (!phone || !address) {
                alert('Mohon lengkapi nomor telepon dan alamat pengiriman');
                return;
            }

            // Disable button
            this.disabled = true;
            this.textContent = 'Memproses...';

            fetch('{{ route("checkout.process") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    phone: phone,
                    address: address
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.snap_token) {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = '{{ route("checkout.success") }}?order_id=' + data.order_id;
                        },
                        onPending: function(result) {
                            window.location.href = '{{ route("checkout.success") }}?order_id=' + data.order_id;
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal, silakan coba lagi');
                            location.reload();
                        },
                        onClose: function() {
                            document.getElementById('pay-button').disabled = false;
                            document.getElementById('pay-button').textContent = 'Bayar Sekarang';
                        }
                    });
                } else {
                    alert('Terjadi kesalahan: ' + (data.error || 'Unknown error'));
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan, silakan coba lagi');
                location.reload();
            });
        });
    </script>
    @endpush
</x-app-layout>