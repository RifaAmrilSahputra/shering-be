<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'caption'     => $this->caption,
            'user'        => new UserResource($this->whenLoaded('user')), 
            'media'       => MediaResource::collection($this->whenLoaded('media')),
            'likes_count' => $this->likes->count(),
            'comments_count' => $this->comments->count(),
            'created_at'  => $this->created_at->diffForHumans(),
        ];
    }
}
