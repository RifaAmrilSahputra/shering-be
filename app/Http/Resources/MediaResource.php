<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'file_path' => Storage::url($this->file_path), // otomatis jadi URL yang bisa diakses
            'type'      => $this->type, // image / video
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
