<?php

namespace App\Http\Requests\Task;

use App\Contracts\Task\Priority;
use App\Contracts\Task\Status;
use App\Http\Requests\BaseRequest;
use App\Models\Project;
use Illuminate\Validation\Rule;

class TaskCreateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $project = Project::find($this->input('project_id'));

        return $this->user()?->can('create', [$project]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => Rule::enum(Status::class),
            'priority' => Rule::enum(Priority::class),
            'due_at' => [
                'nullable',
                Rule::date()->format('Y-m-d')
            ],
            'assignee_id' => 'string|uuid',
        ];
    }
}
