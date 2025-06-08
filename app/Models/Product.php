<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';
    protected $primaryKey = 'id_product';

    protected $fillable = [
        'id_store',
        'id_category',
        'product_name',
        'slug',
        'description',
        'price',
        'stock',
        'product_image'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'id_store', 'id_store');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'id_category', 'id_category');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id_product', 'id_product');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'id_product', 'id_product');
    }
}
