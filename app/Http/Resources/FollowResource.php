<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'follower'    => new UserResource($this->whenLoaded('follower')), // user yang mengikuti
            'following'   => new UserResource($this->whenLoaded('following')), // user yang diikuti
            'created_at'  => $this->created_at->diffForHumans(),
        ];
    }
}
