<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($item, $key) {
                return [
                    'id'=>$item->id,
                    'name' => $item->name,
                    'lname'=>$item->lname,
                    'parent_id'=>$item->parent_id,
                    'parent'=>$item->parent,
                    'child'=>$item->child
                ];
            })
        ];
    }
}
