<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Katalog Produk E-Commerce') }}
            </h2>
            @can('create', App\Models\Product::class)
                <a href="{{ route('products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md text-sm shadow">
                    + Tambah Produk Baru
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search & Filter Bar -->
            <div class="bg-white p-4 rounded-lg shadow-sm mb-6 flex flex-wrap gap-4 items-center justify-between">
                <form action="{{ route('products.index') }}" method="GET" class="flex flex-1 gap-2">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau deskripsi produk..." class="border-gray-300 rounded-md shadow-sm w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    @if($category)
                        <input type="hidden" name="category" value="{{ $category }}">
                    @endif
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-700">Cari</button>
                    @if($search || $category)
                        <a href="{{ route('products.index') }}" class="bg-red-50 text-red-600 border border-red-200 px-3 py-2 rounded-md text-sm hover:bg-red-100">Reset</a>
                    @endif
                </form>

                <!-- Category Pills -->
                <div class="flex gap-2 flex-wrap text-xs">
                    <a href="{{ route('products.index', ['search' => $search]) }}" class="px-3 py-1.5 rounded-full border {{ !$category ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-gray-100 text-gray-700 border-gray-200 hover:bg-gray-200' }}">
                        Semua Kategori
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('products.index', ['category' => $cat->slug, 'search' => $search]) }}" class="px-3 py-1.5 rounded-full border {{ $category === $cat->slug ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-gray-100 text-gray-700 border-gray-200 hover:bg-gray-200' }}">
                            {{ $cat->name }} ({{ $cat->products_count }})
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                                    <span>📦 No Image</span>
                                </div>
                            @endif
                            <div class="p-4">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-xs font-semibold text-indigo-600 uppercase">{{ $product->category?->name }}</span>
                                    <span class="text-xs px-2 py-0.5 rounded {{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        Stok: {{ $product->stock }}
                                    </span>
                                </div>
                                <h3 class="font-bold text-gray-900 text-base line-clamp-1">
                                    <a href="{{ route('products.show', $product->id) }}" class="hover:text-indigo-600">
                                        {{ $product->title }}
                                    </a>
                                </h3>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $product->description }}</p>
                                
                                <div class="flex flex-wrap gap-1 mt-2">
                                    @foreach($product->tags as $tag)
                                        <span class="text-[10px] bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded">#{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="p-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="font-bold text-indigo-700 text-sm">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <div class="flex space-x-1">
                                <a href="{{ route('products.show', $product->id) }}" class="p-1.5 text-gray-600 hover:text-indigo-600 rounded bg-gray-50 hover:bg-gray-100 text-xs" title="Detail">
                                    👁️
                                </a>
                                @can('update', $product)
                                    <a href="{{ route('products.edit', $product->id) }}" class="p-1.5 text-amber-600 hover:text-amber-800 rounded bg-amber-50 hover:bg-amber-100 text-xs" title="Edit">
                                        ✏️
                                    </a>
                                @endcan
                                @can('delete', $product)
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-red-600 hover:text-red-800 rounded bg-red-50 hover:bg-red-100 text-xs" title="Hapus">
                                            🗑️
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-8 rounded-xl text-center text-gray-500">
                        Tidak ada produk yang ditemukan.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
