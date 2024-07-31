<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'user'=>new UserResource($this->user),
            'title'=>$this->title,
            'short_content'=>$this->short_content,
            'content'=>$this->content,
            "tegs"=>$this->tags,
            'category'=>$this->category->name,
        ];
    }
}
