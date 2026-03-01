<?php

declare(strict_types=1);

namespace Modules\Permission\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255|unique:modules,name,' . $this->route('permission'),
            'label' => 'sometimes|string|max:255',
            'icon' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'active' => 'boolean',
        ];
    }
}
