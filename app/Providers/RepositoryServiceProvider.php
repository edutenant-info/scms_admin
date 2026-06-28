<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Contracts\InstitutionRepositoryInterface;
use App\Repositories\Contracts\OrganisationRepositoryInterface;
use App\Repositories\InstitutionRepository;
use App\Repositories\OrganisationRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Map repository contracts to their concrete implementations.
     *
     * @var array<class-string, class-string>
     */
    public array $bindings = [
        OrganisationRepositoryInterface::class => OrganisationRepository::class,
        InstitutionRepositoryInterface::class => InstitutionRepository::class,
    ];
}
