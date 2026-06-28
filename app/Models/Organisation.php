<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organisation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'name',
        'slug',
        'domain',
        'email',
        'mobile',
        'password',
        'logo',
        'fav_icon',
        'login_template',
        'dashboard_template',
        'mou_document',
        'po_date',
        'po_effective_date',
        'contract_period',
        'is_2fa_enabled',
        'is_email_sms',
        'vendor_type',
        'sms_vendor',
        'payment_gateway_vendor',
        'must_reset_password',
        'is_active',
        'type',
        'plan',
        'metadata'
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_2fa_enabled' => 'boolean',
            'must_reset_password' => 'boolean',
            'po_date' => 'date',
            'po_effective_date' => 'date',
            'metadata' => 'json'
        ];
    }

    public function institutions(): HasMany
    {
        return $this->hasMany(Institution::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(OrganisationAddress::class);
    }

    public function pocs(): HasMany
    {
        return $this->hasMany(OrganisationPoc::class);
    }
}
