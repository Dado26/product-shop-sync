<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public const STATUS_AVAILABLE   = 'available';
    public const STATUS_UNAVAILABLE = 'unavailable';

    protected $fillable = ['title', 'description', 'status', 'url', 'site_id', 'specifications', 'synced_at', 'product_shop_id'];

    protected $dates = ['synced_at'];

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
