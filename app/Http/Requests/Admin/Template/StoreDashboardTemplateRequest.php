<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Template;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreDashboardTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (! $this->filled('code') && $this->filled('name')) {
            $this->merge(['code' => Str::slug((string) $this->input('name'))]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $id = $this->route('dashboard_template')?->id;

        return [
            'name'        => ['required', 'string', 'min:3', 'max:100'],
            'code'        => ['required', 'string', 'max:100', 'alpha_dash', Rule::unique('dashboard_templates', 'code')->ignore($id)],
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
