<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institution extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'organisation_id',
        'institution_type_id',
        'board_id',
        'dashboard_template_id',
        'name',
        'slug',
        'email',
        'mobile',
        'password',
        'sub_domain',
        'domain',
        'zonal_partner_name',
        'logo',
        'fav_icon',
        'database_name',
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
            'metadata' => 'json',
        ];
    }

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function institutionType(): BelongsTo
    {
        return $this->belongsTo(InstitutionType::class);
    }

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function dashboardTemplate(): BelongsTo
    {
        return $this->belongsTo(DashboardTemplate::class);
    }

    public function partners(): HasMany
    {
        return $this->hasMany(InstitutionPartner::class);
    }

    public function institutionAddress(): HasOne
    {
        return $this->hasOne(InstitutionAddress::class);
    }
}
