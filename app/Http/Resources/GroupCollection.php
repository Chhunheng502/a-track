<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GroupCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->mapToGroups(function ($item, $key) {
                return [
                    $item['subject'] => $item['section']
                ];
            })->map(function ($item, $key) {
                return [
                    'subject' => $key,
                    'sections' => $item
                ];
            })->values(),
        ];
    }
}
