<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Emergencycontacts extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    //Adhering to the JSON:API Specification
    //First, we need to adhere to the top level document structure having a data, automatically done by laravel for us
    //memeber that contains a resource object with the representation of our model,
    //according to the JSON:API specification, the IDs must be string.


    public function toArray($request)
    {
        return [
            'id' => (string) $this->id,
            'type' => "emergencycontacts",
            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
                'phone_number' => \Illuminate\Support\Str::replaceFirst('0', '+234', $this->phonenumber),
            ]
        ];
    }
}
