<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes','string','unique:roles,name,'.$this->route('role')->id],
            'display_name' => ['sometimes','string'],
            'description' => ['nullable','string'],
            'active' => ['sometimes','boolean'],
        ];
    }
}