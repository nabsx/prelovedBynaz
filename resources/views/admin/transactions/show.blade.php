{{-- resources/views/admin/transactions/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Transaksi: {{ $transaction->order_id }}
            </h2>
            <a href="{{ route('admin.transactions.index') }}" class="text-pink-600 hover:text-pink-700 font-semibold">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Transaction Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Details -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold mb-4">Informasi Pesanan</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order ID:</span>
                            <span class="font-semibold">{{ $transaction->order_id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal:</span>
                            <span class="font-semibold">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span>{!! $transaction->status_badge !!}</span>
                        </div>
                        @if($transaction->payment_type)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Metode Pembayaran:</span>
                            <span class="font-semibold">{{ ucfirst($transaction->payment_type) }}</span>
                        </div>
                        @endif
                        @if($transaction->paid_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dibayar pada:</span>
                            <span class="font-semibold">{{ $transaction->paid_at->format('d M Y, H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Customer Details -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold mb-4">Informasi Pembeli</h3>
                    @php
                        $customerDetails = json_decode($transaction->customer_details, true);
                    @endphp
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama:</span>
                            <span class="font-semibold">{{ $transaction->user->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-semibold">{{ $transaction->user->email }}</span>
                        </div>
                        @if(isset($customerDetails['phone']))
                        <div class="flex justify-between">
                            <span class="text-gray-600">Telepon:</span>
                            <span class="font-semibold">{{ $customerDetails['phone'] }}</span>
                        </div>
                        @endif
                        @if(isset($customerDetails['address']))
                        <div>
                            <span class="text-gray-600 block mb-1">Alamat:</span>
                            <span class="font-semibold">{{ $customerDetails['address'] }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold mb-4">Produk yang Dibeli</h3>
                    <div class="space-y-4">
                        @foreach($transaction->items as $item)
                            <div class="flex gap-4 pb-4 border-b last:border-0">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" 
                                    class="w-20 h-20 object-cover rounded">
                                <div class="flex-1">
                                    <h4 class="font-semibold">{{ $item->product->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                    <h3 class="text-lg font-bold mb-4">Ringkasan</h3>
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Total Item:</span>
                            <span>{{ $transaction->items->sum('quantity') }} produk</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between font-bold text-lg">
                            <span>Total:</span>
                            <span class="text-pink-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>