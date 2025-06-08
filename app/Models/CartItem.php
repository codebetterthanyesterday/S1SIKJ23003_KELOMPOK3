<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    public $timestamps = false;
    protected $table = 'cart_items';
    protected $primaryKey = 'id_cart_item';

    protected $fillable = [
        'id_group',
        'id_product',
        'quantity'
    ];

    public function group()
    {
        return $this->belongsTo(CartGroup::class, 'id_group', 'id_group');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    public function cartGroup()
    {
        return $this->belongsTo(CartGroup::class, 'id_group', 'id_group');
    }
}
