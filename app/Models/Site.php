<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Site extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'url', 'email'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function SyncRules()
    {
        return $this->hasOne(SyncRules::class);
    }

    public function Product()
    {
        return $this->hasMany(Product::class);
    }
}
