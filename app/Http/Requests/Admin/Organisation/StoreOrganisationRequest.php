<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Organisation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreOrganisationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Auto-generate the slug from the organisation name when not supplied.
     */
    protected function prepareForValidation(): void
    {
        if (! $this->filled('slug') && $this->filled('name')) {
            $this->merge(['slug' => Str::slug((string) $this->input('name'))]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            // Core identity
            'name'                  => ['required', 'string', 'min:5', 'max:180'],
            'slug'                  => ['required', 'string', 'max:200', 'alpha_dash', Rule::unique('organisations', 'slug')],
            'email'                 => ['required', 'email', 'min:4', 'max:70', Rule::unique('organisations', 'email')],
            'mobile'                => ['required', 'digits:10', Rule::unique('organisations', 'mobile')],
            'password'              => ['required', 'string', 'min:3', 'max:20', 'confirmed'],

            // Domains (optional, validated only when present)
            'sub_domain'            => ['nullable', 'string', 'min:3', 'max:70', Rule::unique('organisations', 'sub_domain')],
            'domain'                => ['nullable', 'string', 'min:3', 'max:100', Rule::unique('organisations', 'domain')],

            // Documents & contract
            'mou_document'          => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'po_date'               => ['nullable', 'date'],
            'po_effective_date'     => ['nullable', 'date'],
            'contract_period'       => ['nullable', 'integer', 'min:1', 'max:100'],

            // Templates (required dropdowns, must reference an active template)
            'login_template_id'     => ['required', Rule::exists('login_templates', 'id')->where('is_active', true)],
            'dashboard_template_id' => ['required', Rule::exists('dashboard_templates', 'id')->where('is_active', true)],

            // Branding
            'logo'                  => ['required', 'image', 'max:2048'],
            'fav_icon'              => ['required', 'image', 'max:1024'],

            // Flags
            'is_2fa_enabled'        => ['nullable', 'boolean'],
            'is_active'             => ['nullable', 'boolean'],

            // Address (basic validation)
            'address'               => ['nullable', 'string', 'max:1000'],
            'landline'              => ['nullable', 'string', 'max:20'],
            'pincode'               => ['nullable', 'string', 'max:20'],
            'geocode'               => ['nullable', 'string', 'max:255'],
            'post_office'           => ['nullable', 'string', 'max:255'],
            'country'               => ['nullable', 'string', 'max:255'],
            'state'                 => ['nullable', 'string', 'max:255'],
            'city'                  => ['nullable', 'string', 'max:255'],
            'district'              => ['nullable', 'string', 'max:255'],
            'taluk'                 => ['nullable', 'string', 'max:255'],

            // Points of contact (at least one fully-specified contact required)
            'pocs'                  => ['required', 'array', 'min:1'],
            'pocs.*.name'           => ['required', 'string', 'min:3', 'max:50'],
            'pocs.*.designation'    => ['required', 'string', 'min:3', 'max:50'],
            'pocs.*.mobile'         => ['required', 'digits:10'],
            'pocs.*.email'          => ['required', 'email', 'min:4', 'max:50'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'login_template_id'     => 'login template',
            'dashboard_template_id' => 'dashboard template',
            'pocs.*.name'           => 'contact name',
            'pocs.*.designation'    => 'contact designation',
            'pocs.*.mobile'         => 'contact mobile',
            'pocs.*.email'          => 'contact email',
        ];
    }
}
