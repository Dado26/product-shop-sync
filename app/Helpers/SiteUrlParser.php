<?php

namespace App\Helpers;

use App\Models\Site;

class SiteUrlParser
{
    /**
     * @param  string  $url
     * @param  bool  $withoutException
     *
     * @return \App\Models\Site|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public static function getSite(string $url, bool $withoutException = false)
    {
        $domain = parse_url($url);
        $domain = $domain['host'];

        $site = Site::where('url', 'LIKE', "%$domain%");

        if ($withoutException) {
            return $site->first();
        }

        return $site->firstOrFail();
    }
}
