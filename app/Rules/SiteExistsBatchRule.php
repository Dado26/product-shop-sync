<?php

namespace App\Rules;

use App\Helpers\SiteUrlParser;
use Illuminate\Contracts\Validation\Rule;

class SiteExistsBatchRule implements Rule
{
    /**
     * @var array
     */
    protected $missing = [];

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $urls = SiteUrlParser::splitUrlsByNewLine($value);

        foreach ($urls as $url) {
            if (SiteUrlParser::getSite($url, true) === null) {
                $this->missing[] = parse_url($url)['host'];
            }
        }
        return count($this->missing) === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Please create site(s) with rules first, list of missing sites: " . implode('; ', $this->missing);
    }
}
