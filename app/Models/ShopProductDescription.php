<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProductDescription extends Model
{
    protected $table = 'product_description';

    protected $fillable   = ['description', 'name', 'product_id'];
    protected $connection = 'shop';
}
