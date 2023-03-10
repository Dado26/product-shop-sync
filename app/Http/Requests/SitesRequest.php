<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SitesRequest extends FormRequest
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
            'sites.name'                => 'required|min:2',
            'sites.url'                 => 'required|url',
            'sites.email'               => 'required|email',
            'sites.price_modification'  => 'required|numeric|min:-100|max:100',
            'sites.tax_percent'         => 'required|numeric|min:-100|max:100',
            'sites.login_url'           => 'nullable|url',
            'sites.username'            => 'nullable|min:2',
            'sites.password'            => 'nullable|min:4',
            'sites.session_name'        => 'nullable|min:2',
            'sync_Rules.title'          => 'required|min:2',
            //'sync_Rules.description'    => 'required|min:6',
            'sync_Rules.price'          => 'required',
            'sync_Rules.in_stock'       => 'required',
            'sync_Rules.in_stock_value' => 'required',
            'sync_Rules.images'         => 'required',
            'sync_Rules.price_decimals' => 'required|integer|min:0|max:2',
        ];
    }

    public function attributes()
    {
        return [
            'sites.name'                => 'name',
            'sites.url'                 => 'url',
            'sites.email'               => 'email',
            'sites.price_modification'  => 'price modification',
            'sites.tax_percent'         => 'tax percent',
            'sites.login_url'           => 'login url',
            'sites.username'            => 'username',
            'sites.password'            => 'password',
            'sites.session_name'        => 'session name',
            'sync_Rules.title'          => 'title',
            //'sync_Rules.description'    => 'description',
            'sync_Rules.price'          => 'price',
            'sync_Rules.price_decimals' => 'price decimals',
            'sync_Rules.in_stock'       => 'in stock',
            'sync_Rules.in_stock_value' => 'in stock value',
            'sync_Rules.images'         => 'images',
        ];
    }
}
