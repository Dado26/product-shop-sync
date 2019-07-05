<?php

namespace App\Models;

use App\Models\Variant;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use App\Models\Site;


class Product extends Model
{
      use SoftDeletes;

      public const STATUS_AVAILABLE = 'available';
      public const STATUS_UNAVAILABLE = 'unavailable';

      protected $fillable = ['title', 'description','category','status','url','site_id'];

      public function variants(){
            return $this->hasMany(Variant::class);
      }

      public function productImages(){
            return $this->hasMany(ProductImage::class);
      }

      public function site(){
            return $this->belongsTo(Site::class);
      }
}
