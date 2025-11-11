<?php

namespace App\Http\Resources\Organization;

use App\Support\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var User $user */
        $user = $this->resource->user;

        return [
            'name' => $user->name,
            'email' => $user->email,
            'uuid' => $user->uuid,
            'role' => $user->role
        ];
    }
}
