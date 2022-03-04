<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'body' => $this->body,
            'view_count' => $this->view_count,
            'image' => $this->image,
            'status' => $this->status,
            'comment_count' => $this->comments->count(),
            'user' => $this->user,
            'category_id'=>$this->category_id,
            'comments'=>new CommentCollection($this->comments)
        ];
    }
}
