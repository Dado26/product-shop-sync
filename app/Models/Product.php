<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
      public const STATUS_AVAILABLE = 'available';
      public const STATUS_UNAVAILABLE = 'unavailable';

      protected $fillable = ['title', 'description','category','status','url','site_id'];
}
