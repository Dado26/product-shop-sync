<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSession extends Model
{
    protected $fillable = ['site_id', 'value', 'expires_at', 'updated_at'];

    protected $table = 'sessions';

    protected $dates = ['expires_at'];

    const CREATED_AT = null;
    

    public function expired()
    {
        return $this->expires_at->subMinutes(5)->isPast();
    }
}
