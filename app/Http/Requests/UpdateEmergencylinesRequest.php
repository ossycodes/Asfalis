<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmergencylinesRequest extends FormRequest
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
            "data.id" => "required|string",
            "data.type" => "required|in:emergencylines",
            "data.attributes" => "sometimes|required|array",
            "data.attributes.name" => "sometimes|required|string",
            "data.attributes.description" => "sometimes|required|string",
            "data.attributes.telephone_number" => "sometimes|required|string",
        ];
    }
}
