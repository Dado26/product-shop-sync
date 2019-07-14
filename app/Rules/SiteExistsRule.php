<?php

namespace App\Rules;

use App\Helpers\SiteUrlParser;
use Illuminate\Contracts\Validation\Rule;

class SiteExistsRule implements Rule
{
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
        return SiteUrlParser::getSite($value, true) !== null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Site from the url doesn't exist in our database, please create site with rules first.";
    }
}
