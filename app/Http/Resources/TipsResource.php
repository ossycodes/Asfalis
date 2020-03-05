<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TipsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => (string) $this->id,
            "user_id" => (string) $this->user_id,
            "type" => "tips",
            "attributes" => [
                "body" => $this->body
            ],
            'relationships' => [
                'user' => [
                    'links' => [
                        'self' => route(
                            'profile'
                        ),
                        'related' => route(
                            'user.tips'
                        ),
                    ]
                ],
            ],
            'included' => [
                'id' => (string) $this->user->id,
                'type' => 'users',
                'attributes' => [
                    "first_name" => $this->user->first_name,
                    "last_name" => $this->user->last_name,
                    "email" => $this->user->email,
                    "phone_number" => $this->user->phonenumber
                ],
            ],
        ];
    }
}
