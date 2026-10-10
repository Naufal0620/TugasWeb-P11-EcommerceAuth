<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard - Restricted Area') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">👑 Panel Administrator</h3>
                        <p class="text-sm text-gray-600 mt-1">Halaman ini dilindungi oleh middleware <code>['auth', 'role:admin']</code>.</p>
                    </div>
                    <a href="/admin" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded shadow">
                        Buka Filament Admin Panel &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-5">
                        <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">Total Produk</span>
                        <p class="text-3xl font-extrabold text-indigo-900 mt-2">{{ \App\Models\Product::count() }}</p>
                    </div>
                    <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-5">
                        <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Total Kategori</span>
                        <p class="text-3xl font-extrabold text-emerald-900 mt-2">{{ \App\Models\Category::count() }}</p>
                    </div>
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-5">
                        <span class="text-xs font-semibold text-amber-600 uppercase tracking-wider">Total Transaksi</span>
                        <p class="text-3xl font-extrabold text-amber-900 mt-2">{{ \App\Models\Order::count() }}</p>
                    </div>
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-5">
                        <span class="text-xs font-semibold text-purple-600 uppercase tracking-wider">Total Users</span>
                        <p class="text-3xl font-extrabold text-purple-900 mt-2">{{ \App\Models\User::count() }}</p>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h4 class="font-bold text-gray-800 mb-3">Informasi Akun Anda:</h4>
                    <ul class="text-sm space-y-1 text-gray-700">
                        <li><strong>Nama:</strong> {{ Auth::user()->name }}</li>
                        <li><strong>Email:</strong> {{ Auth::user()->email }}</li>
                        <li><strong>Role:</strong> <span class="bg-red-100 text-red-800 px-2 py-0.5 rounded font-mono text-xs font-bold">{{ Auth::user()->role }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
