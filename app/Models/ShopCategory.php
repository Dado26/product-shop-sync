<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

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

    public static function allWithFormattedNames()
    {
        $results = DB::connection('shop')->select("SELECT 
                cp.category_id AS category_id, 
                GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' > ') AS name, 
                c1.parent_id, 
                c1.sort_order 
            FROM category_path cp 
                LEFT JOIN category c1 ON (cp.category_id = c1.category_id) 
                LEFT JOIN category c2 ON (cp.path_id = c2.category_id) 
                LEFT JOIN category_description cd1 ON (cp.path_id = cd1.category_id) 
                LEFT JOIN category_description cd2 ON (cp.category_id = cd2.category_id) 
            WHERE 
                cd1.language_id = '2' AND  cd2.language_id = '2' 
            GROUP BY cp.category_id 
            ORDER BY name");

        return collect($results);
    }
}
