<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Institution;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateInstitutionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Auto-generate the slug from the institution name when not supplied.
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
        $id = $this->route('institution')->id;

        return [
            // Core identity
            'organisation_id'     => ['required', 'integer', Rule::exists('organisations', 'id')],
            'name'                => ['required', 'string', 'min:5', 'max:180'],
            'slug'                => ['required', 'string', 'max:200', 'alpha_dash', Rule::unique('institutions', 'slug')->ignore($id)],
            'institution_type_id' => ['required', Rule::exists('institution_types', 'id')->where('is_active', true)],
            'board_id'            => ['required', Rule::exists('boards', 'id')->where('is_active', true)],

            // Account (password optional on update — leave blank to keep current)
            'email'               => ['required', 'email', 'min:4', 'max:70', Rule::unique('institutions', 'email')->ignore($id)],
            'mobile'              => ['required', 'digits:10'],
            'password'            => ['nullable', 'string', 'min:3', 'max:20', 'confirmed'],

            // Domains (optional, validated only when present)
            'sub_domain'          => ['nullable', 'string', 'min:3', 'max:70', Rule::unique('institutions', 'sub_domain')->ignore($id)],
            'domain'              => ['nullable', 'string', 'min:3', 'max:10', Rule::unique('institutions', 'domain')->ignore($id)],

            // Branding & template (files optional on update)
            'logo'                => ['nullable', 'image', 'max:2048'],
            'fav_icon'            => ['nullable', 'image', 'max:1024'],
            'dashboard_template_id' => ['required', Rule::exists('dashboard_templates', 'id')->where('is_active', true)],

            // Tenant
            'database_name'       => ['nullable', 'string', 'min:5', 'max:20'],
            'is_active'           => ['nullable', 'boolean'],

            // Partners (at least one fully-specified contact required)
            'zonal_partner_name'  => ['required', 'string', 'min:4', 'max:50'],
            'partners'            => ['required', 'array', 'min:1'],
            'partners.*.name'        => ['required', 'string', 'min:3', 'max:50'],
            'partners.*.designation' => ['required', 'string', 'min:3', 'max:50'],
            'partners.*.mobile'      => ['required', 'digits:10'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'institution_type_id'    => 'institution type',
            'board_id'               => 'board',
            'dashboard_template_id'  => 'dashboard template',
            'zonal_partner_name'     => 'zonal partner name',
            'partners.*.name'        => 'partner name',
            'partners.*.designation' => 'partner designation',
            'partners.*.mobile'      => 'partner mobile',
        ];
    }
}
