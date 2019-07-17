<?php

namespace App\Models;

class ShopCategory extends ShopModel
{
    protected $table      = 'category';

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
