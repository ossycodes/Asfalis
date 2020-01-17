<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfile extends FormRequest
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
            "data" => "required|array",
            "data.type" => "required|in:users",
            "data.attributes" => "required|array",
            'data.attributes.first_name' => 'required|string|max:150',
            'data.attributes.last_name' => 'required|string|max:150',
            'data.attributes.phonenumber' => 'required|digits:11',
        ];
    }
}
