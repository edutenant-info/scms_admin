<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Institution;
use App\Repositories\Contracts\InstitutionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class InstitutionRepository extends BaseRepository implements InstitutionRepositoryInterface
{
    public function __construct(Institution $model)
    {
        parent::__construct($model);
    }

    public function search(?string $term, int $perPage = 12): LengthAwarePaginator
    {
        return $this->query()
            ->with(['organisation:id,name', 'institutionType:id,name', 'board:id,name'])
            ->when(filled($term), function ($query) use ($term) {
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', "%{$term}%")
                        ->orWhere('slug', 'like', "%{$term}%")
                        ->orWhereHas('organisation', fn ($oq) => $oq->where('name', 'like', "%{$term}%"));
                });
            })
            ->latest()
            ->paginate($perPage);
    }
}
