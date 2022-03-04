<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends ResourceCollection
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
                    'id' => $item->id,
                    'user' => $item->user,
                    'parent' => $item->parent,
                    'approved' => $item->approved,
                    'comment' => $item->comment,
                    'commentable' => $item->commentable,
                    'child' => $item->child,
                    'created_at'=>jdate($item->created_at)->format('Y-m-d')
                ];
            })
        ];
    }
}
