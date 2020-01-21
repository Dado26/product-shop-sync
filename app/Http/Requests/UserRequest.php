<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'first_name' => 'min:2',
            'last_name'  => 'min:3',
            'email'      => 'required|email|unique:users',
            'password'   => 'confirmed|required|min:8',
        ];

        if (request()->isMethod('PUT') && empty(request()->get('password'))) {
            unset($rules['password']);
        }
        if (request()->isMethod('PUT')) {
            $rules['email'] =  'required|email|unique:users,email,' . request()->user->id;
        }

        return $rules;
    }
}
