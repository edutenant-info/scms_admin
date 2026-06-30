<?php

declare(strict_types=1);

namespace App\Services\Institution;

use App\Models\Board;
use App\Models\DashboardTemplate;
use App\Models\Institution;
use App\Models\InstitutionType;
use App\Repositories\Contracts\InstitutionRepositoryInterface;
use App\Repositories\Contracts\OrganisationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

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
     * @return Collection<int, string>
     */
    public function institutionTypeOptions(): Collection
    {
        return InstitutionType::query()->where('is_active', true)->orderBy('name')->pluck('name', 'id');
    }

    /**
     * @return Collection<int, string>
     */
    public function boardOptions(): Collection
    {
        return Board::query()->where('is_active', true)->orderBy('name')->pluck('name', 'id');
    }

    /**
     * @return Collection<int, string>
     */
    public function dashboardTemplateOptions(): Collection
    {
        return DashboardTemplate::query()->where('is_active', true)->orderBy('name')->pluck('name', 'id');
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Institution
    {
        return DB::transaction(function () use ($data) {
            $attributes = $this->mapAttributes($data);
            $attributes['uid'] = (string) Str::uuid();
            $attributes['password'] = Hash::make($data['password']);

            /** @var Institution $institution */
            $institution = $this->institutions->create($attributes);

            $this->syncPartners($institution, $data);

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

            if (! empty($data['password'])) {
                $attributes['password'] = Hash::make($data['password']);
            }

            /** @var Institution $institution */
            $institution = $this->institutions->update($institution, $attributes);

            $this->syncPartners($institution, $data);

            return $institution;
        });
    }

    public function delete(Institution $institution): bool
    {
        return $this->institutions->delete($institution);
    }

    /**
     * Map validated input onto institution column attributes (excludes password & relations).
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function mapAttributes(array $data, ?Institution $existing = null): array
    {
        $attributes = Arr::only($data, [
            'organisation_id',
            'institution_type_id',
            'board_id',
            'dashboard_template_id',
            'name',
            'slug',
            'email',
            'mobile',
            'sub_domain',
            'domain',
            'zonal_partner_name',
            'database_name',
        ]);

        $attributes['is_active'] = (bool) ($data['is_active'] ?? false);

        if (($data['logo'] ?? null) instanceof UploadedFile) {
            $attributes['logo'] = $data['logo']->store('institutions/logos', 'public');
        }

        if (($data['fav_icon'] ?? null) instanceof UploadedFile) {
            $attributes['fav_icon'] = $data['fav_icon']->store('institutions/favicons', 'public');
        }

        return $attributes;
    }

    /**
     * Replace the institution's partner contacts with the submitted set.
     *
     * @param  array<string, mixed>  $data
     */
    private function syncPartners(Institution $institution, array $data): void
    {
        $partners = collect($data['partners'] ?? [])
            ->filter(static fn ($p) => filled($p['name'] ?? null) || filled($p['mobile'] ?? null))
            ->map(static fn ($p) => [
                'name' => $p['name'] ?? '',
                'designation' => $p['designation'] ?? null,
                'mobile' => $p['mobile'] ?? '',
            ])
            ->values();

        // Replace the full set on every save.
        $institution->partners()->delete();

        if ($partners->isNotEmpty()) {
            $institution->partners()->createMany($partners->all());
        }
    }
}
