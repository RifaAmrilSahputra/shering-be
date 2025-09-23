<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'user'      => new UserResource($this->whenLoaded('user')), // user yang memberi like
            'created_at'=> $this->created_at->diffForHumans(),
        ];
    }
}
