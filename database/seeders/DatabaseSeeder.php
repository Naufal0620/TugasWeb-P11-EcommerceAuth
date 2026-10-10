<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Pengguna untuk Setiap Role
        $admin = User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@unimed.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $editor = User::create([
            'name' => 'Content Editor',
            'email' => 'editor@unimed.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'editor',
        ]);

        $user = User::create([
            'name' => 'Regular Customer',
            'email' => 'user@unimed.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // 2. Buat Kategori Produk
        $categories = ['Elektronik', 'Pakaian & Fashion', 'Buku & Alat Tulis', 'Makanan & Minuman', 'Olahraga'];
        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[] = Category::create([
                'name' => $cat,
                'slug' => Str::slug($cat),
                'description' => 'Koleksi produk kategori ' . $cat,
            ]);
        }

        // 3. Buat Tags
        $tags = ['Promo', 'Terlaris', 'New Arrival', 'Original', 'Limited'];
        $createdTags = [];
        foreach ($tags as $t) {
            $createdTags[] = Tag::create([
                'name' => $t,
                'slug' => Str::slug($t),
            ]);
        }

        // 4. Generate 55 Data Produk Realistis via Factory
        Product::factory(55)->create()->each(function ($product) use ($createdTags) {
            // Attach 1 - 3 tag acak ke produk (Many-to-Many)
            $randomTags = collect($createdTags)->random(rand(1, 3))->pluck('id');
            $product->tags()->attach($randomTags);
        });

        // 5. Buat Demo Transaksi / Order
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'total_amount' => 1500000,
            'status' => 'completed',
        ]);

        $sampleProducts = Product::take(3)->get();
        foreach ($sampleProducts as $sp) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $sp->id,
                'quantity' => 2,
                'price' => $sp->price,
            ]);
        }
    }
}
