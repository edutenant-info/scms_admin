<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganisationPoc extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'organisation_id',
        'name',
        'designation',
        'mobile',
        'email',
        'created_by',
        'modified_by',
    ];

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }
}
