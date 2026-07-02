<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Masters\Fees;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMasterCategoryRequest extends FormRequest
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
        $id = $this->route('master_category')?->id;

        return [
            'name'        => ['required', 'string', 'min:1', 'max:100', Rule::unique('master_categories', 'name')->ignore($id)],
            'description' => ['nullable', 'string', 'max:255'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $data = parent::validated();
        $data['is_active'] = $this->boolean('is_active');

        return $data;
    }
}
