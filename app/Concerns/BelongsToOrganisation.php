<?php

namespace App\Concerns;

trait BelongsToOrganisation
{
    protected static function bootBelongsToOrganisation(): void
    {
        static::addGlobalScope('organisation', function ($builder) {
            if (tenancy()->isInitialized()) {
                $orgId = tenancy()->current()->root()->getTenantId(); // Organisation = root of chain
                $builder->where($builder->getModel()->getTable().'.organisation_id', $orgId);
            }
        });
        static::creating(function ($m) {
            if (tenancy()->isInitialized() && empty($m->organisation_id)) {
                $m->organisation_id = tenancy()->current()->root()->getTenantId();
            }
        });
    }
}