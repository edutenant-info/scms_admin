<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstitutionAddress extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'institution_id',
        'address',
        'pincode',
        'post_office',
        'country',
        'state',
        'district',
        'taluk',
        'city',
    ];

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }
}
