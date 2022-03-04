<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
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
                    'title' => $item->title,
                    'summary'=>$item->summary,
                    'body'=>$item->body,
                    'view_count'=>$item->view_count,
                    'image'=>$item->image,
                    'status'=>$item->status,
                    'comment_count'=>$item->comments->count(),
                    'user'=>$item->user,
                    'created_at'=>jdate($item->created_at)->format('Y-m-d'),
                    'category'=>$item->category
                ];
            })
        ];
    }
}
