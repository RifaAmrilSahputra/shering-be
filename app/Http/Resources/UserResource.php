<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'email'    => $this->email,
            'avatar'   => $this->avatar ?? null, // kalau nanti ada foto profil
            'followers_count' => $this->followers->count(),
            'following_count' => $this->followings->count(),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
