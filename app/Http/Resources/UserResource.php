<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommentResource;

class UserResource extends JsonResource
{
    public static $wrap = 'user';

    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'username'  => $this->username,
            'name'      => $this->name,
            'last_name' => $this->last_name,
            'email'     => $this->email,
            'role'      => $this->role,
            'comments'  => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
