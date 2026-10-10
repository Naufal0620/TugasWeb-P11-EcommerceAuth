<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'image',
        'title',
        'slug',
        'description',
        'price',
        'stock',
        'is_active',
    ];

    // Relasi Many-to-One: Produk milik 1 Kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi Many-to-One: Produk diinput oleh 1 User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi Many-to-Many: Produk memiliki banyak Tag (via pivot product_tag)
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    // Relasi One-to-Many: Produk ada di banyak OrderItem
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Local Query Scope: Memfilter produk yang aktif dan stok tersedia
    public function scopeAvailable($query)
    {
        return $query->where('is_active', true)->where('stock', '>', 0);
    }

    // Local Query Scope: Filter berdasarkan kategori
    public function scopeInCategory($query, $categoryName)
    {
        return $query->whereRelation('category', 'name', $categoryName);
    }
}
