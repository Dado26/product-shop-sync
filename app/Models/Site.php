<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'url', 'email', 'price_modification', 'tax_percent', 'login_url', 'username', 'password', 'session_name', 'username_input_field', 'password_input_field', 'login_button_text', 'auth_element_check'];

    public function getPasswordAttribute($value)
    {
        if ($value) {
            return decrypt($value);
        }
        return null;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = encrypt($value);
    }

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

    public function productsActive()
    {
        return $this->hasMany(Product::class)->where('status', '=', Product::STATUS_AVAILABLE);
    }

    public function productsUnavailable()
    {
        return $this->hasMany(Product::class)->where('status', '=', Product::STATUS_UNAVAILABLE);
    }

    public function productsDeleted()
    {
        return $this->hasMany(Product::class)->onlyTrashed();
    }

    public function session()
    {
        return $this->hasOne(SiteSession::class);
    }
}
