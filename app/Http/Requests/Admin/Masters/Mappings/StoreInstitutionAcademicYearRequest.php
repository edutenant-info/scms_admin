<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Masters\Mappings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInstitutionAcademicYearRequest extends FormRequest
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
        $id = $this->route('institution_academic_year')?->id;

        return [
            'institution_id'   => ['required', 'integer', 'exists:institutions,id'],
            'academic_year_id' => [
                'required',
                'integer',
                'exists:academic_years,id',
                Rule::unique('institution_academic_years', 'academic_year_id')
                    ->where('institution_id', (int) $this->input('institution_id'))
                    ->ignore($id),
            ],
            'is_active'        => ['nullable', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'academic_year_id.unique' => 'This Academic Year is already mapped to the selected Institution.',
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $data = parent::validated();
        $data['is_active'] = $this->boolean('is_active');

        return $data;
    }
}
