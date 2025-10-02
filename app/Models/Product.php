<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'description',
        'buy_price',
        'price',
        'discount',
        'stock_quantity',
        'is_active',
        'is_featured',
        'specifications'
    ];

    protected $casts = [
        'specifications' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    protected $appends = ['final_price', 'discount_percentage', 'average_rating', 'reviews_count'];

    // Automatically generate slug from name
    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
            // Ensure unique slug
            $originalSlug = $product->slug;
            $count = 1;
            while (static::where('slug', $product->slug)->exists()) {
                $product->slug = $originalSlug . '-' . $count++;
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = Str::slug($product->name);
                // Ensure unique slug
                $originalSlug = $product->slug;
                $count = 1;
                while (static::where('slug', $product->slug)->where('id', '!=', $product->id)->exists()) {
                    $product->slug = $originalSlug . '-' . $count++;
                }
            }
        });
    }

    // Relationships

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes')
            ->withPivot('value', 'order')
            ->withTimestamps();
    }


    // public function orderItems()
    // {
    //     return $this->hasMany(OrderItem::class);
    // }

    // Accessors
    public function getFinalPriceAttribute()
    {
        return $this->discount ? $this->price - $this->discount : $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        return $this->discount ? round(($this->discount / $this->price) * 100) : 0;
    }

    public function getPrimaryImageAttribute()
    {
        return $this->images()->where('is_primary', true)->first() ?? $this->images()->first();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopeWithDiscount($query)
    {
        return $query->whereNotNull('discount')->where('discount', '>', 0);
    }

    // Methods
    public function isInStock()
    {
        return $this->stock_quantity > 0;
    }

    public function hasDiscount()
    {
        return !is_null($this->discount) && $this->discount > 0;
    }

    public function decreaseStock($quantity)
    {
        $this->stock_quantity -= $quantity;
        return $this->save();
    }

    public function increaseStock($quantity)
    {
        $this->stock_quantity += $quantity;
        return $this->save();
    }
}