<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TagResource;

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
            'id'            => $this->id,
            'title'         => $this->postTranslation?->title,
            'description'   => $this->postTranslation?->description,
            'content'       => $this->postTranslation?->content,
            'language_id'   => $this->postTranslation?->language_id,
            'tags'          => TagResource::collection($this->whenLoaded('tags')),
        ];
    }
}
