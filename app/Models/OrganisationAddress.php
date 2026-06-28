<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganisationAddress extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'organisation_id',
        'landline',
        'pincode',
        'geocode',
        'post_office',
        'country',
        'state',
        'city',
        'district',
        'taluk',
        'address',
        'created_by',
        'modified_by',
    ];

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }
}
