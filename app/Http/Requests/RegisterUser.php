<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUser extends FormRequest
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
        //note:checkout africastalking laravel package steal the guy's phonenumber regrex 
        //phonenumber validation and add as a custom rule.
        return [
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'phonenumber' => 'required|digits:11|unique:users,phonenumber' ,
            'address' => 'required|string',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ];
    }
}
