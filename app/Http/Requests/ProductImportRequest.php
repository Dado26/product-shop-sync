<?php

namespace App\Http\Requests;

use App\Rules\SiteExistsRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url'      => [
                'required',
                'url',
                'unique:products,url',
                new SiteExistsRule,
            ],
            'category' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'url.unique' => 'This product was already imported',
        ];
    }
}
