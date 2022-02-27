<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
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
                    'email'=>$item->email,
                    'email_verified_at'=>$item->email_verified_at,
                    'phone_number'=>$item->phone_number,
                ];
            })
        ];
    }
}
