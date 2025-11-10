<?php

namespace App\Http\Requests\Project;

use App\Contracts\Project\Status;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ProjectListRequest extends BaseRequest
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
        ];
    }
}
