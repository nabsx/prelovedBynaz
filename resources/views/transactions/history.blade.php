{{-- resources/views/transactions/history.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Riwayat Pesanan</h1>

        @if($transactions->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <div class="text-6xl mb-4">📦</div>
                <p class="text-gray-500 text-lg mb-6">Belum ada riwayat pesanan</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700 transition">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($transactions as $transaction)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                                <div>
                                    <p class="text-sm text-gray-500">Order ID</p>
                                    <p class="font-semibold text-lg">{{ $transaction->order_id }}</p>
                                </div>
                                <div class="mt-2 sm:mt-0 text-left sm:text-right">
                                    <p class="text-sm text-gray-500">Tanggal</p>
                                    <p class="font-semibold">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mb-4 pb-4 border-b">
                                <div>
                                    <p class="text-sm text-gray-500">Total Pembayaran</p>
                                    <p class="text-2xl font-bold text-pink-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    {!! $transaction->status_badge !!}
                                </div>
                            </div>

                            <!-- Transaction Items -->
                            <div class="space-y-3 mb-4">
                                @foreach($transaction->items as $item)
                                    <div class="flex gap-4">
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" 
                                            class="w-16 h-16 object-cover rounded">
                                        <div class="flex-1">
                                            <h3 class="font-semibold">{{ $item->product->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($transaction->status === 'pending')
                                <button onclick="payAgain('{{ $transaction->snap_token }}')" 
                                    class="w-full bg-pink-600 text-white py-2 rounded-lg hover:bg-pink-700 transition">
                                    Bayar Sekarang
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        function payAgain(snapToken) {
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    location.reload();
                },
                onPending: function(result) {
                    location.reload();
                },
                onError: function(result) {
                    alert('Pembayaran gagal');
                }
            });
        }
    </script>
    @endpush
</x-app-layout>