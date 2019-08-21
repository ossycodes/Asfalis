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
    public function toArray($request)
    {
        return [
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'phonenumber' => \Illuminate\Support\Str::replaceFirst('0', '+234', $this->phonenumber),
            'registered' => $this->created_at->diffForHumans(),
            'emergencycontacts' => Emergencycontacts::collection($this->whenLoaded('emergencycontacts')),
        ];
    }
}
