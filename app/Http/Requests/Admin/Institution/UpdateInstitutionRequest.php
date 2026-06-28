<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Institution;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInstitutionRequest extends FormRequest
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
        $institutionId = $this->route('institution')->id;

        return [
            'organisation_id' => ['required', 'integer', Rule::exists('organisations', 'id')],
            'name'            => ['required', 'string', 'max:255'],
            'display_name'    => ['nullable', 'string', 'max:255'],
            'slug'            => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('institutions', 'slug')->ignore($institutionId)],
            'type'            => ['nullable', 'string', 'max:100'],
            'board'           => ['nullable', 'string', 'max:100'],
            'database_name'   => ['nullable', 'string', 'max:255'],
            'is_active'       => ['nullable', 'boolean'],

            // Address (hasOne)
            'address'         => ['nullable', 'string', 'max:1000'],
            'pincode'         => ['nullable', 'string', 'max:20'],
            'post_office'     => ['nullable', 'string', 'max:255'],
            'country'         => ['nullable', 'string', 'max:255'],
            'state'           => ['nullable', 'string', 'max:255'],
            'district'        => ['nullable', 'string', 'max:255'],
            'taluk'           => ['nullable', 'string', 'max:255'],
            'city'            => ['nullable', 'string', 'max:255'],
        ];
    }
}
