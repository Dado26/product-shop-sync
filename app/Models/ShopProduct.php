<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    protected $table = 'product';

    protected $fillable = ['model', 'image', 'price', 'location', 'status'];

    protected $connection = 'shop';
}
