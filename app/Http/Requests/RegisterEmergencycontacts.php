<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterEmergencycontacts extends FormRequest
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
            'contacts.*.name' => 'required|string',
            'contacts.*.email' => 'required|email|unique:emergencycontacts,email|unique:users',
            'contacts.*.phonenumber' => 'required|digits:11|unique:emergencycontacts,phonenumber'
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
            'contacts.*.email.unique' => 'emergencycontact email is already registered',
            'contacts.*.phonenumber.unique'  => 'emergencycontact phonenumber is already registered',
        ];
    }
}
