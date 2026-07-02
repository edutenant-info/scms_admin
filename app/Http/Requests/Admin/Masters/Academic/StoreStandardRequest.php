<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Masters\Academic;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStandardRequest extends FormRequest
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
        $id = $this->route('standard')?->id;

        return [
            'name'        => ['required', 'string', 'min:3', 'max:100', Rule::unique('standards', 'name')->ignore($id)],
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
