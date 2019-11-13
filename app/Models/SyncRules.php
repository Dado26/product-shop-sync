<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncRules extends Model
{
    protected $table = 'sync_rules';

    protected $primaryKey = 'site_id';

    public $timestamps = false;

    protected $fillable = [
        'title', 'description', 'specifications', 'price', 'in_stock', 'in_stock_value', 'images', 'variants',
        'price_decimals', 'site_id', 'sku', 'remove_string_from_sku',
    ];
}
