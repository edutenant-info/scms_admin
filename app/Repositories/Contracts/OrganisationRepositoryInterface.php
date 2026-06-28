<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrganisationRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Paginate organisations, optionally filtered by a search term.
     */
    public function search(?string $term, int $perPage = 12): LengthAwarePaginator;
}
