<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Organisation;
use App\Repositories\Contracts\OrganisationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrganisationRepository extends BaseRepository implements OrganisationRepositoryInterface
{
    public function __construct(Organisation $model)
    {
        parent::__construct($model);
    }

    public function search(?string $term, int $perPage = 12): LengthAwarePaginator
    {
        return $this->query()
            ->withCount('institutions')
            ->when(filled($term), function ($query) use ($term) {
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', "%{$term}%")
                        ->orWhere('slug', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%")
                        ->orWhere('mobile', 'like', "%{$term}%");
                });
            })
            ->latest()
            ->paginate($perPage);
    }
}
