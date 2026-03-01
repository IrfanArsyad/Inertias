<?php

declare(strict_types=1);

namespace Modules\Permission\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name,' . $this->route('role'),
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'active' => 'boolean',
            'read' => 'nullable|array',
            'create' => 'nullable|array',
            'update' => 'nullable|array',
            'delete' => 'nullable|array',
        ];
    }
}
