<?php

namespace App\Models;

class ShopCategoryDescription extends ShopModel
{
    protected $table      = 'category_description';

    protected $connection = 'shop';

    protected $primaryKey = 'category_id';

    public function shopCategory()
    {
        return $this->belongsTo(ShopCategory::class, 'category_id');
    }
}
