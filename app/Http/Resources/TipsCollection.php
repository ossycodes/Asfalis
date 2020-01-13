<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TipsCollection extends ResourceCollection
{
     /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = TipsResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "data" => $this->collection
        ];
    }
}
