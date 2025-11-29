<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'sale_price',
        'cost_price',
        'sku',
        'stock_quantity',
        'unit',
        'weight',
        'image',
        'gallery',
        'category_id',
        'type',
        'rating',
        'reviews_count',
        'is_featured',
        'is_active',
        'is_organic',
        'expiry_date',
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'is_organic' => 'boolean',
        'expiry_date' => 'date',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    // Polymorphic relationship for images
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function primaryImage()
    {
        return $this->morphOne(Image::class, 'imageable')->where('is_primary', true);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    public function getIsOnSaleAttribute()
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }

    public function getImageUrlAttribute()
    {
        if ($this->primaryImage) {
            return $this->primaryImage->url;
        }
        return $this->image ? asset('storage/' . $this->image) : asset('admin/images/thumb-bananas.png');
    }
}
