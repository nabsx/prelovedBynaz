{{-- resources/views/checkout/success.blade.php --}}
<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="text-6xl mb-4">✅</div>
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Pesanan Berhasil!</h1>
            
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <div class="text-sm text-gray-600 mb-2">Order ID</div>
                <div class="text-xl font-bold text-gray-800 mb-4">{{ $transaction->order_id }}</div>
                
                <div class="text-sm text-gray-600 mb-2">Total Pembayaran</div>
                <div class="text-2xl font-bold text-pink-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</div>
            </div>

            <div class="space-y-3 mb-6">
                @if($transaction->status === 'pending')
                    <p class="text-gray-600">Mohon selesaikan pembayaran Anda untuk melanjutkan pesanan.</p>
                @elseif($transaction->status === 'success')
                    <p class="text-gray-600">Terima kasih! Pembayaran Anda telah kami terima.</p>
                    <p class="text-gray-600">Pesanan akan segera kami proses.</p>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('transactions.history') }}" 
                    class="inline-block bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700 transition">
                    Lihat Pesanan Saya
                </a>
                <a href="{{ route('products.index') }}" 
                    class="inline-block bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
                    Lanjut Belanja
                </a>
            </div>
        </div>
    </div>
</x-app-layout>