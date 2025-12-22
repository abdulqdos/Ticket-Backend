<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type'  => 'image',
            'attributes' => [
                'file_name' => $this->file_name,
                'mime_type' => $this->mime_type,
                'size' => $this->size,
                'url' => $this->original_url,
            ],
        ];
    }
}
