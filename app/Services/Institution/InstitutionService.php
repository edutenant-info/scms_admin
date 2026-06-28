<?php

declare(strict_types=1);

namespace App\Services\Institution;

use App\Models\Institution;
use App\Repositories\Contracts\InstitutionRepositoryInterface;
use App\Repositories\Contracts\OrganisationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InstitutionService
{
    public function __construct(
        private readonly InstitutionRepositoryInterface $institutions,
        private readonly OrganisationRepositoryInterface $organisations,
    ) {
    }

    public function paginate(?string $search, int $perPage = 12): LengthAwarePaginator
    {
        return $this->institutions->search($search, $perPage);
    }

    /**
     * Organisations keyed by id for use in <select> options.
     *
     * @return Collection<int, string>
     */
    public function organisationOptions(): Collection
    {
        return $this->organisations->all([], ['id', 'name'])
            ->sortBy('name')
            ->pluck('name', 'id');
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Institution
    {
        return DB::transaction(function () use ($data) {
            $attributes = $this->mapAttributes($data);

            /** @var Institution $institution */
            $institution = $this->institutions->create($attributes);

            $this->syncAddress($institution, $data);

            return $institution;
        });
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Institution $institution, array $data): Institution
    {
        return DB::transaction(function () use ($institution, $data) {
            $attributes = $this->mapAttributes($data, $institution);

            /** @var Institution $institution */
            $institution = $this->institutions->update($institution, $attributes);

            $this->syncAddress($institution, $data);

            return $institution;
        });
    }

    public function delete(Institution $institution): bool
    {
        return $this->institutions->delete($institution);
    }

    /**
     * Map validated input onto institution column attributes (excludes relations).
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function mapAttributes(array $data, ?Institution $existing = null): array
    {
        $attributes = Arr::only($data, [
            'organisation_id',
            'name',
            'slug',
            'database_name',
        ]);

        $attributes['is_active'] = (bool) ($data['is_active'] ?? false);

        // type & board have no dedicated columns — persist them in metadata,
        // preserving any other metadata already stored on the model.
        $metadata = $existing?->metadata ?? [];
        if (array_key_exists('type', $data)) {
            $metadata['type'] = $data['type'] ?: null;
        }
        if (array_key_exists('board', $data)) {
            $metadata['board'] = $data['board'] ?: null;
        }
        if (array_key_exists('display_name', $data)) {
            $metadata['display_name'] = $data['display_name'] ?: null;
        }
        $metadata = array_filter($metadata, static fn ($value) => $value !== null && $value !== '');
        $attributes['metadata'] = $metadata !== [] ? $metadata : null;

        return $attributes;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function syncAddress(Institution $institution, array $data): void
    {
        $addressData = Arr::only($data, [
            'address',
            'pincode',
            'post_office',
            'country',
            'state',
            'district',
            'taluk',
            'city',
        ]);

        // Skip entirely if every address field is blank.
        if (count(array_filter($addressData, static fn ($v) => filled($v))) === 0) {
            return;
        }

        $institution->institutionAddress()->updateOrCreate([], $addressData);
    }
}
