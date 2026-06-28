<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institution extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'organisation_id',
        'board_id',
        'institution_type_id',
        'stream_id',
        'combination_id',
        'standard_id',
        'semester_id',
        'section_id',
        'name',
        'display_name',
        'slug',
        'domain',
        'email',
        'mobile',
        'landline',
        'institution_logo',
        'fav_icon',
        'area_partner_name',
        'area_partner_email',
        'area_partner_phone',
        'zonal_partner_name',
        'po_date',
        'po_effective_date',
        'contract_period',
        'priority',
        'is_active',
        'metadata'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'po_date' => 'date',
            'po_effective_date' => 'date',
            'priority' => 'integer',
            'metadata' => 'json'
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

    public function stream(): BelongsTo
    {
        return $this->belongsTo(Stream::class);
    }

    public function combination(): BelongsTo
    {
        return $this->belongsTo(Combination::class);
    }

    public function standard(): BelongsTo
    {
        return $this->belongsTo(Standard::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function institutionAddress(): HasOne
    {
        return $this->hasOne(InstitutionAddress::class);
    }

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class)
            ->withPivot('is_active')
            ->withTimestamps();
    }
}
