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
            'sites.name'=> 'required|min:2',
            'sites.url'=> 'required|url',
            'sites.email'=>'email',
            'sync_Rules.title' => 'required|min:2',
            'sync_Rules.description'=> 'required|min:6',
            'sync_Rules.price'=> 'required',
            'sync_Rules.in_stock'=>'required',
            'sync_Rules.in_stock_value'=>'required',
            'sync_Rules.images' =>'required'
                     
        ];
    }

    public function attributes()
    {
        return [
            'sites.name'=> 'name',
            'sites.url'=>'url',
            'sites.email'=>'email',
            'sync_Rules.title'=>'title',
            'sync_Rules.description'=>'description',
            'sync_Rules.price'=>'price',
            'sync_Rules.in_stock'=>'in_stock',
            'sync_Rules.in_stock_value'=>'in_stock_value',
            'sync_Rules.images'=>'images'
        ];
    }
}
