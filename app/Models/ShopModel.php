<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class ShopModel extends Model
{
    protected $guarded = [];

    protected $connection = 'shop';

    public $timestamps = false;
}
