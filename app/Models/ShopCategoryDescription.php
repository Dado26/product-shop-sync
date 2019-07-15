<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCategoryDescription extends Model
{
    protected $table      = 'category_description';
    protected $connection = 'shop';

    public function shopCategory()
    {
        return $this->belongsTo(ShopCategory::class, 'category_id');
    }
}
