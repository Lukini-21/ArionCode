<?php

namespace App\Http\Resources\Project;

use App\Support\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectMemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var User $member */
        $member = $this->resource->member;

        return [
            'name' => $member->name,
            'email' => $member->email,
            'uuid' => $member->uuid,
            'role' => $member->role
        ];
    }
}
