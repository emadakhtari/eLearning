<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Route;

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
    public function rules(Request $request)
    {
        $route = Route::currentRouteName();

        $rules = [
            'name'             => 'required',
            'family'           => 'required',
            'phone'            => [
                'required',
                'unique:users',
                'regex:/09[0-9]{9}|۰۹[۰-۹]{9}/',
            ],
            'national_code'            => [
                'nullable',
                'unique:users',
            ],
            'email'            => [
                'nullable',
                'unique:users',
            ],
            'user_category_id' => 'required|exists:user_categories,id',
        ];
        if ($route == 'Users.Edit') {
            if (empty($request['password'])) {
                $rules['password'] = '';
            }
            if (Auth()->user()->hasPermission('Users.Edit')) {
                $rules['phone'] = 'unique:users,phone,' . $request->input('user_id');
                $rules['email'] = 'unique:users,email,' . $request->input('user_id');
                $rules['national_code'] = 'unique:users,national_code,' . $request->input('user_id');
            } else {
                $rules['national_code'] = '';
                $rules['name'] = '';
                $rules['family'] = '';
                $rules['phone'] = '';
                $rules['email'] = '';
                $rules['user_category_id'] = '';
            }

        }
        return $rules;
    }
}
