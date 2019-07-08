<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'url', 'email'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function syncRules()
    {
        return $this->hasOne(SyncRules::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
