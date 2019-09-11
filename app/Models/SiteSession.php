<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSession extends Model
{
    protected $table = 'sessions';

    protected $dates = ['expires_at'];

    public function expired()
    {
        return $this->expires_at->subMinutes(5)->isPast();
    }
}
