<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Emergencyline extends JsonResource
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
            'type' => 'emergencylines',
            'attributes' => [
                'name' => $this->name,
                'description' => $this->description,
                'telephone_number' => $this->telephone_number
            ]

        ];
    }
}
