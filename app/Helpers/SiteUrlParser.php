<?php

namespace App\Helpers;

use App\Models\Site;

class SiteUrlParser
{
    /**
     * @param string $url
     * @param bool   $withoutException
     *
     * @return \App\Models\Site|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public static function getSite(string $url, bool $withoutException = false)
    {
        $domain = parse_url($url);
        $domain = $domain['host'];

        $domain = str_replace('www.', '', $domain);

        $site = Site::where('url', 'LIKE', "%$domain%");

        if ($withoutException) {
            return $site->first();
        }

        return $site->firstOrFail();
    }

    /**
     * @param $urls
     *
     * @return array
     */
    public static function splitUrlsByNewLine($urls): array
    {
        $urlsArray = explode(PHP_EOL, $urls);

        return collect($urlsArray)->map(function ($url) {
            return trim(preg_replace('/\s+/', ' ', $url));
        })->unique()->filter()->values()->toArray();
    }
}
