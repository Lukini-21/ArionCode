<?php

namespace App\Http\Requests\Project;

use App\Contracts\Project\Status;
use App\Http\Requests\BaseRequest;
use App\Models\Project;
use Illuminate\Validation\Rule;

class ProjectCreateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', Project::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = auth()->user();

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects')->where(function ($query) use ($user) {
                    return $query->where('organization_id', $user->orgId);
                })->withoutTrashed()
            ],
            'description' => 'string',
            'is_public' => 'boolean',
            'status' => Rule::enum(Status::class),
            'starts_at' => [
                'nullable',
                Rule::date()->format('Y-m-d')
            ],
            'ends_at' => [
                'nullable',
                Rule::date()->format('Y-m-d')
            ],
        ];
    }
}
