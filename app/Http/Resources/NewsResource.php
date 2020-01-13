<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            "type" => "news",
            "attributes" => [
                "title" => $this->title,
                "description" => $this->description,
                "body" => $this->body
            ]
        ];
    }
}
