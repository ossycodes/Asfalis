<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IssuesResource extends JsonResource
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
            "type" => "issues",
            "attributes" => [
                "location" => $this->location,
                "description" => $this->description,
            ]
        ];
    }
}
