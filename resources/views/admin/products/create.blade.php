{{-- resources/views/admin/products/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Produk Baru
            </h2>
            <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Product Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Produk <span class="text-red-600">*</span>
                    </label>
                    <input type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 @error('name') border-red-500 @enderror"
                        placeholder="Contoh: Wardah Lightening Serum"
                        required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Produk <span class="text-red-600">*</span>
                    </label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="4"
                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 @error('description') border-red-500 @enderror"
                        placeholder="Jelaskan kondisi produk, sisa berapa persen, expired date, dll."
                        required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price & Stock -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga <span class="text-red-600">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                            <input type="number" 
                                name="price" 
                                id="price" 
                                value="{{ old('price') }}"
                                class="w-full pl-12 rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 @error('price') border-red-500 @enderror"
                                placeholder="50000"
                                min="0"
                                step="1000"
                                required>
                        </div>
                        @error('price')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                            Stok <span class="text-red-600">*</span>
                        </label>
                        <input type="number" 
                            name="stock" 
                            id="stock" 
                            value="{{ old('stock', 1) }}"
                            class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 @error('stock') border-red-500 @enderror"
                            placeholder="10"
                            min="0"
                            required>
                        @error('stock')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Category & Condition -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-600">*</span>
                        </label>
                        <select name="category" 
                            id="category" 
                            class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 @error('category') border-red-500 @enderror"
                            required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="skincare" {{ old('category') == 'skincare' ? 'selected' : '' }}>Skincare</option>
                            <option value="makeup" {{ old('category') == 'makeup' ? 'selected' : '' }}>Makeup</option>
                            <option value="tools" {{ old('category') == 'tools' ? 'selected' : '' }}>Tools</option>
                            <option value="fragrance" {{ old('category') == 'fragrance' ? 'selected' : '' }}>Fragrance</option>
                        </select>
                        @error('category')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">
                            Kondisi <span class="text-red-600">*</span>
                        </label>
                        <select name="condition" 
                            id="condition" 
                            class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 @error('condition') border-red-500 @enderror"
                            required>
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="like_new" {{ old('condition') == 'like_new' ? 'selected' : '' }}>Seperti Baru (90-100%)</option>
                            <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Baik (70-89%)</option>
                            <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>Cukup Baik (50-69%)</option>
                        </select>
                        @error('condition')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Product Image -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Produk <span class="text-red-600">*</span>
                    </label>
                    <div class="flex items-center justify-center w-full">
                        <label for="image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-12 h-12 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500">
                                    <span class="font-semibold">Klik untuk upload</span> atau drag and drop
                                </p>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG (MAX. 2MB)</p>
                            </div>
                            <input id="image" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(event)" required />
                        </label>
                    </div>
                    @error('image')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    <!-- Image Preview -->
                    <div id="imagePreview" class="mt-4 hidden">
                        <img id="preview" src="" alt="Preview" class="max-h-64 rounded-lg mx-auto">
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" 
                            name="is_active" 
                            value="1" 
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-pink-600 focus:ring-pink-500">
                        <span class="ml-2 text-sm text-gray-700">Aktifkan produk</span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-pink-500 to-purple-600 text-white py-3 rounded-lg hover:from-pink-600 hover:to-purple-700 transition font-semibold">
                        💾 Simpan Produk
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-lg hover:bg-gray-300 transition text-center font-semibold">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview');
                const imagePreview = document.getElementById('imagePreview');
                preview.src = reader.result;
                imagePreview.classList.remove('hidden');
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    @endpush
</x-app-layout>