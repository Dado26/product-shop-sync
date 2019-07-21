<?php

namespace App\Rules;

use App\Helpers\SiteUrlParser;
use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;

class UniqueProductUrlBatchRule implements Rule
{
    /**
     * @var array
     */
    protected $exists = [];

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
            if (Product::where('url', $url)->first() !== null) {
                $this->exists[] = $url;
            }
        }

        return count($this->exists) === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "These products already exist in our database: " . implode('; ', $this->exists);
    }
}
