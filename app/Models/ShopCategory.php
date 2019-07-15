<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCategory extends Model
{
    protected $table      = 'category';
    protected $connection = 'shop';
    protected $primaryKey = 'category_id';

    public function categoryDescriptions()
    {
        return $this->hasMany(ShopCategoryDescription::class, 'category_id');
    }

    public function languageCategoryDescriptions()
    {
        return $this->hasMany(ShopCategoryDescription::class, 'category_id')->where('language_id', 2);
    }
}
