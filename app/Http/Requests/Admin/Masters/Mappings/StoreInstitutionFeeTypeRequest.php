<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Masters\Mappings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInstitutionFeeTypeRequest extends FormRequest
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
        $id = $this->route('institution_fee_type')?->id;

        return [
            'institution_id' => ['required', 'integer', 'exists:institutions,id'],
            'fee_type_id'    => [
                'required',
                'integer',
                'exists:fee_types,id',
                Rule::unique('institution_fee_types', 'fee_type_id')
                    ->where('institution_id', (int) $this->input('institution_id'))
                    ->ignore($id),
            ],
            'is_active'      => ['nullable', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'fee_type_id.unique' => 'This Fee Type is already mapped to the selected Institution.',
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $data = parent::validated();
        $data['is_active'] = $this->boolean('is_active');

        return $data;
    }
}
