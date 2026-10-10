<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Produk: ') . $product->title }}
            </h2>
            <a href="{{ route('products.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                &larr; Kembali ke Katalog
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-full h-80 object-cover rounded-xl shadow">
                        @else
                            <div class="w-full h-80 bg-gray-100 flex items-center justify-center text-gray-400 rounded-xl">
                                <span class="text-lg">📦 Gambar Tidak Tersedia</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-col justify-between">
                        <div>
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                    {{ $product->category?->name }}
                                </span>
                                <span class="text-xs {{ $product->stock > 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} px-2 py-0.5 rounded font-medium">
                                    Stok: {{ $product->stock }} unit
                                </span>
                            </div>

                            <h1 class="text-2xl font-extrabold text-gray-900 mb-2">{{ $product->title }}</h1>
                            <p class="text-2xl font-bold text-indigo-600 mb-4">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>

                            <div class="border-t border-b py-4 my-4">
                                <h4 class="text-sm font-semibold text-gray-700 mb-1">Deskripsi Produk:</h4>
                                <p class="text-gray-600 text-sm whitespace-pre-line leading-relaxed">{{ $product->description }}</p>
                            </div>

                            <div class="mb-4">
                                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tags:</h4>
                                <div class="flex flex-wrap gap-1">
                                    @forelse($product->tags as $tag)
                                        <span class="bg-gray-100 text-gray-700 text-xs px-2.5 py-1 rounded-full font-medium">#{{ $tag->name }}</span>
                                    @empty
                                        <span class="text-gray-400 text-xs">Tidak ada tag</span>
                                    @endforelse
                                </div>
                            </div>

                            @if($product->user)
                                <div class="text-xs text-gray-500">
                                    Diupload oleh: <strong class="text-gray-700">{{ $product->user->name }}</strong> (Role: {{ $product->user->role }})
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 pt-4 border-t flex space-x-3">
                            @can('update', $product)
                                <a href="{{ route('products.edit', $product->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white font-medium py-2 px-4 rounded-md text-sm shadow">
                                    ✏️ Edit Produk
                                </a>
                            @endcan

                            @can('delete', $product)
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md text-sm shadow">
                                        🗑️ Hapus Produk
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
