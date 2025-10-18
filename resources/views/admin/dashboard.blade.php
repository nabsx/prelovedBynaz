{{-- resources/views/admin/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm">Total Produk</p>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Product::count() }}</p>
                    </div>
                    <div class="text-4xl">📦</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm">Total Transaksi</p>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Transaction::count() }}</p>
                    </div>
                    <div class="text-4xl">🛒</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm">Transaksi Berhasil</p>
                        <p class="text-3xl font-bold text-green-600">{{ \App\Models\Transaction::where('status', 'success')->count() }}</p>
                    </div>
                    <div class="text-4xl">✅</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-pink-600">
                            Rp {{ number_format(\App\Models\Transaction::where('status', 'success')->sum('total_amount'), 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="text-4xl">💰</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <a href="{{ route('admin.products.create') }}" class="bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold mb-2">Tambah Produk Baru</h3>
                        <p class="text-pink-100">Upload produk beauty care baru</p>
                    </div>
                    <div class="text-5xl">➕</div>
                </div>
            </a>

            <a href="{{ route('admin.transactions.index') }}" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold mb-2">Lihat Semua Transaksi</h3>
                        <p class="text-blue-100">Kelola dan monitor transaksi</p>
                    </div>
                    <div class="text-5xl">📊</div>
                </div>
            </a>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold mb-4">Transaksi Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pembeli</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach(\App\Models\Transaction::with('user')->latest()->take(5)->get() as $transaction)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm">{{ $transaction->order_id }}</td>
                                <td class="px-4 py-3 text-sm">{{ $transaction->user->name }}</td>
                                <td class="px-4 py-3 text-sm font-semibold">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm">{!! $transaction->status_badge !!}</td>
                                <td class="px-4 py-3 text-sm">{{ $transaction->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>