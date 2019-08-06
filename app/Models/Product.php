<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public const STATUS_AVAILABLE   = 'available';
    public const STATUS_UNAVAILABLE = 'unavailable';
    public const STATUS_ARCHIVED    = 'archived';
    public const STATUS_DELETED     = 'deleted';

    protected $fillable = ['title', 'description', 'status', 'url', 'site_id', 'specifications', 'synced_at', 'queued_at', 'shop_product_id'];

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

    public function scopeAvailable($query)
    {
        return $query->where('status', $this::STATUS_AVAILABLE);
    }

    public function scopeAvailableOrUnvailable($query)
    {
        
        return $query->where('status', $this::STATUS_AVAILABLE)->OrWhere('status', $this::STATUS_UNAVAILABLE);
    }
}
