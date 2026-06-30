<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'sub_domain',
        'domain',
        'email',
        'mobile',
        'password',
        'logo',
        'fav_icon',
        'login_template_id',
        'dashboard_template_id',
        'mou_document',
        'po_date',
        'po_effective_date',
        'contract_period',
        'is_2fa_enabled',
        'is_active',
        'metadata',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_2fa_enabled' => 'boolean',
            'po_date' => 'date',
            'po_effective_date' => 'date',
            'contract_period' => 'integer',
            'metadata' => 'json'
        ];
    }

    public function institutions(): HasMany
    {
        return $this->hasMany(Institution::class);
    }

    public function loginTemplate(): BelongsTo
    {
        return $this->belongsTo(LoginTemplate::class);
    }

    public function dashboardTemplate(): BelongsTo
    {
        return $this->belongsTo(DashboardTemplate::class);
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
