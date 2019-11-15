<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLinkRule extends Model
{
    protected $primaryKey = 'site_id';

    protected $table = 'products_link_rules';

    protected $fillable = ['next_page', 'product_link', 'site_id'];
}
