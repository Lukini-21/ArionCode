<?php

namespace App\Http\Resources;

use App\Support\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var User $user */
        $user = $this->resource;

        return [
            'name' => $user->name,
            'email' => $user->email,
            'uuid' => $user->uuid,
        ];
    }
}
