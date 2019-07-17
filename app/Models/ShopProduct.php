<?php

namespace App\Models;

class ShopProduct extends ShopModel
{
    protected $table = 'product';

    protected $primaryKey = 'product_id';

    public function categories()
    {
        return $this->belongsToMany(ShopCategory::class, 'product_to_category', 'product_id', 'category_id');
    }
}
