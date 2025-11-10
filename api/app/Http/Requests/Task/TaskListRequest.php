<?php

namespace App\Http\Requests\Task;

use App\Contracts\Task\Priority;
use App\Contracts\Task\Status;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class TaskListRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => Rule::enum(Status::class),
            'search' => 'string|nullable',
            'assignee_id' => 'string|nullable',
            'priority' => Rule::enum(Priority::class),
        ];
    }
}
