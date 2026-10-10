<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    // Admin dan Editor boleh membuat produk baru
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    // Admin & Editor bebas edit, user biasa hanya boleh edit produk miliknya sendiri
    public function update(User $user, Product $product): bool
    {
        return in_array($user->role, ['admin', 'editor']) || $user->id === $product->user_id;
    }

    // Hanya Admin yang memiliki wewenang menghapus produk
    public function delete(User $user, Product $product): bool
    {
        return $user->role === 'admin';
    }
}
