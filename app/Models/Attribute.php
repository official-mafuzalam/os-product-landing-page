<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'is_active'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attributes')
            ->withPivot('value', 'order')
            ->withTimestamps();
    }

    // public function orderItems()
    // {
    //     return $this->belongsToMany(OrderItem::class, 'order_item_attributes')
    //         ->withPivot('value', 'order')
    //         ->withTimestamps();
    // }

}