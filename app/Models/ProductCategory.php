<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_categories';
    protected $primaryKey = 'id_category';

    protected $fillable = [
        'category_name', 'slug', 'description', 'category_image'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'id_category', 'id_category');
    }
}
