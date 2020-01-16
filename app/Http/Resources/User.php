<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'type' => 'users',
            'attributes' => [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone_number' => \Illuminate\Support\Str::replaceFirst('0', '+234', $this->phonenumber),
                'registered' => $this->created_at->diffForHumans(),
            ],
            'relationships' => [
                'emergencycontacts' => [
                    'links' => [
                        'self' => route(
                            'users.relationships.emergencycontacts',
                            ['id' => $this->id]
                        ),
                        'related' => route(
                            'user.emergencycontacts'
                        ),
                    ]
                ],
            ],
            'included' => $this->emergencycontacts->map(function ($emergencycontact) {
                return [
                    'id' => (string) $emergencycontact->id,
                    'type' => 'emergencycontacts',
                    'attributes' => [
                        "name" => $emergencycontact->name,
                        "email" => $emergencycontact->email,
                        "phone_number" => $emergencycontact->phonenumber
                    ]
                ];
            })
        ];
    }
}
