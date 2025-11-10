<?php

namespace App\Http\Resources\Project;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Project $project */
        $project = $this->resource;

        return [
            'id' => $project->id,
            'name' => $project->name,
            'description' => $project->description,
            'members' => ProjectMemberResource::collection($project->members),
            'status' => $project->status,
            'is_public' => $project->is_public,
            'starts_at' => $project->starts_at,
            'ends_at' => $project->ends_at,
            'created_at' => $project->created_at,
            'tasks_count' => $project->tasks()->count(),
        ];
    }
}
