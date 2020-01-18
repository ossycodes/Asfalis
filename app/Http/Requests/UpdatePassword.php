<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePassword extends FormRequest
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
        //if i dont pass token, error comes up, try and fix.
        return [
            "data" => "required|array",
            "data.type" => "required|in:users",
            "data.attributes.old_password" => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail('old password is incorrect.');
                    }
                },
            ],
            'data.attributes.new_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (Hash::check($value, auth()->user()->password)) {
                        $fail('new password cannot be the same as your old password.');
                    }
                },
            ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'old_password.required' => 'old password is required',
            'new_password.required'  => 'new password is required',
        ];
    }
}
