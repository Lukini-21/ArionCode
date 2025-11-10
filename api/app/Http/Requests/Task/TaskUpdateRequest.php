<?php

namespace App\Http\Requests\Task;

use App\Contracts\Task\Priority;
use App\Contracts\Task\Status;
use App\Http\Requests\BaseRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Validation\Rule;

class TaskUpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->model = Task::findOrFail($this->route('task'));

        return $this->user()?->can('update', $this->model);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
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
