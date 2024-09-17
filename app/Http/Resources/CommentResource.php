<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'message' => $this->message,
            'created' => $this->created_at ? Carbon::parse($this->created_at)->format('d.m.Y') : null,
            'user_id' => $this->user_id,
            'userName' => $this->user->name
        ];
    }
}
