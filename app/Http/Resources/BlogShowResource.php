<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogShowResource extends JsonResource
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
            'title' => $this->title,
            'message' => $this->message,
            'userName' => $this->user->name,
            'created_at' => $this->created_at ? Carbon::parse($this->created_at)->format('d.m.Y H:i') : null,
            'comment' => CommentResource::collection($this->comment)
        ];
    }
}
