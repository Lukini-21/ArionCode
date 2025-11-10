<?php

namespace App\Http\Requests\Organization;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class OrganizationSwitchRequest extends BaseRequest
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
        $user = $this->user();

        return [
            "orgId" => [
                "required",
                "numeric",
                "exists:organizations,id",
                Rule::exists('organization_users', 'organization_id')->where(function ($query) use ($user) {
                    $query->where('user_id', $user->uuid);
                })
            ],
        ];
    }
}
