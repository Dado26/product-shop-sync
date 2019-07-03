<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncRules extends Model
{
    protected $table = 'sync_rules';

    public $timestamps = false;

    protected $fillable = ['title', 'description', 'price','in_stock','in_stock_value','images','variants', 'site_id'];
}
