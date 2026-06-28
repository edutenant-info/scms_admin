<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Organisation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrganisationRequest extends FormRequest
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
            // Core
            'name'                   => ['required', 'string', 'max:255'],
            'slug'                   => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('organisations', 'slug')],
            'email'                  => ['required', 'email', 'max:255', Rule::unique('organisations', 'email')],
            'mobile'                 => ['required', 'string', 'max:20', Rule::unique('organisations', 'mobile')],
            'domain'                 => ['nullable', 'string', 'max:255', Rule::unique('organisations', 'domain')],
            'password'               => ['required', 'string', 'min:8'],
            'type'                   => ['nullable', 'string', 'max:100'],
            'plan'                   => ['nullable', 'string', 'max:100'],

            // Branding & documents
            'logo'                   => ['nullable', 'image', 'max:2048'],
            'mou_document'           => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'login_template'         => ['nullable', 'string', 'max:100'],
            'dashboard_template'     => ['nullable', 'string', 'max:100'],

            // Contract
            'po_date'                => ['nullable', 'date'],
            'po_effective_date'      => ['nullable', 'date'],
            'contract_period'        => ['nullable', 'string', 'max:100'],

            // Vendor / integrations
            'is_email_sms'           => ['nullable', 'string', 'max:100'],
            'vendor_type'            => ['nullable', 'string', 'max:100'],
            'sms_vendor'             => ['nullable', 'string', 'max:100'],
            'payment_gateway_vendor' => ['nullable', 'string', 'max:100'],

            // Flags
            'is_2fa_enabled'         => ['nullable', 'boolean'],
            'must_reset_password'    => ['nullable', 'boolean'],
            'is_active'              => ['nullable', 'boolean'],

            // Address (hasOne)
            'address'                => ['nullable', 'string', 'max:1000'],
            'landline'               => ['nullable', 'string', 'max:20'],
            'pincode'                => ['nullable', 'string', 'max:20'],
            'geocode'                => ['nullable', 'string', 'max:255'],
            'post_office'            => ['nullable', 'string', 'max:255'],
            'country'                => ['nullable', 'string', 'max:255'],
            'state'                  => ['nullable', 'string', 'max:255'],
            'city'                   => ['nullable', 'string', 'max:255'],
            'district'               => ['nullable', 'string', 'max:255'],
            'taluk'                  => ['nullable', 'string', 'max:255'],

            // Points of contact (hasMany)
            'pocs'                   => ['nullable', 'array'],
            'pocs.*.name'            => ['nullable', 'string', 'max:255'],
            'pocs.*.designation'     => ['nullable', 'string', 'max:255'],
            'pocs.*.mobile'          => ['nullable', 'string', 'max:20'],
            'pocs.*.email'           => ['nullable', 'email', 'max:255'],
        ];
    }
}
