<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'category',
        'condition',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Auto generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // Relationships
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Helper Methods
    public function getImageUrlAttribute()
    {
        return $this->image 
            ? asset('storage/' . $this->image) 
            : asset('images/no-image.png');
    }

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function getCategoryLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->category));
    }

    public function getConditionLabelAttribute()
    {
        return match($this->condition) {
            'like_new' => 'Seperti Baru',
            'good' => 'Baik',
            'fair' => 'Cukup Baik',
            default => 'Unknown',
        };
    }
}