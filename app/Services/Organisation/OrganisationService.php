<?php

declare(strict_types=1);

namespace App\Services\Organisation;

use App\Models\Organisation;
use App\Repositories\Contracts\OrganisationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OrganisationService
{
    public function __construct(
        private readonly OrganisationRepositoryInterface $organisations,
    ) {
    }

    public function paginate(?string $search, int $perPage = 12): LengthAwarePaginator
    {
        return $this->organisations->search($search, $perPage);
    }

    public function find(int|string $id, array $with = []): ?Organisation
    {
        /** @var Organisation|null $organisation */
        $organisation = $this->organisations->find($id, $with);

        return $organisation;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Organisation
    {
        return DB::transaction(function () use ($data) {
            $attributes = $this->mapAttributes($data);
            $attributes['uid'] = (string) Str::uuid();
            $attributes['password'] = Hash::make($data['password']);

            /** @var Organisation $organisation */
            $organisation = $this->organisations->create($attributes);

            $this->syncAddress($organisation, $data);
            $this->syncPocs($organisation, $data);

            return $organisation;
        });
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Organisation $organisation, array $data): Organisation
    {
        return DB::transaction(function () use ($organisation, $data) {
            $attributes = $this->mapAttributes($data, $organisation);

            if (! empty($data['password'])) {
                $attributes['password'] = Hash::make($data['password']);
            }

            /** @var Organisation $organisation */
            $organisation = $this->organisations->update($organisation, $attributes);

            $this->syncAddress($organisation, $data);
            $this->syncPocs($organisation, $data);

            return $organisation;
        });
    }

    public function delete(Organisation $organisation): bool
    {
        return $this->organisations->delete($organisation);
    }

    /**
     * Map validated input onto organisation column attributes (excludes password & relations).
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function mapAttributes(array $data, ?Organisation $existing = null): array
    {
        $attributes = Arr::only($data, [
            'name',
            'slug',
            'domain',
            'email',
            'mobile',
            'login_template',
            'dashboard_template',
            'po_date',
            'po_effective_date',
            'contract_period',
            'is_email_sms',
            'vendor_type',
            'sms_vendor',
            'payment_gateway_vendor',
        ]);

        $attributes['is_2fa_enabled'] = (bool) ($data['is_2fa_enabled'] ?? false);
        $attributes['must_reset_password'] = (bool) ($data['must_reset_password'] ?? false);
        $attributes['is_active'] = (bool) ($data['is_active'] ?? false);

        // type & plan have no dedicated columns — persist them in metadata,
        // preserving any other metadata already stored on the model.
        $metadata = $existing?->metadata ?? [];
        if (array_key_exists('type', $data)) {
            $metadata['type'] = $data['type'] ?: null;
        }
        if (array_key_exists('plan', $data)) {
            $metadata['plan'] = $data['plan'] ?: null;
        }
        $metadata = array_filter($metadata, static fn ($value) => $value !== null && $value !== '');
        $attributes['metadata'] = $metadata !== [] ? $metadata : null;

        if (($data['logo'] ?? null) instanceof UploadedFile) {
            $attributes['logo'] = $data['logo']->store('organisations/logos', 'public');
        }

        if (($data['mou_document'] ?? null) instanceof UploadedFile) {
            $attributes['mou_document'] = $data['mou_document']->store('organisations/mou', 'public');
        }

        return $attributes;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function syncAddress(Organisation $organisation, array $data): void
    {
        $addressData = Arr::only($data, [
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
        ]);

        // Skip entirely if every address field is blank.
        if (count(array_filter($addressData, static fn ($v) => filled($v))) === 0) {
            return;
        }

        $organisation->address()->updateOrCreate([], $addressData);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function syncPocs(Organisation $organisation, array $data): void
    {
        $pocs = collect($data['pocs'] ?? [])
            ->filter(static fn ($poc) => filled($poc['name'] ?? null) || filled($poc['mobile'] ?? null))
            ->map(static fn ($poc) => [
                'name' => $poc['name'] ?? '',
                'designation' => $poc['designation'] ?? null,
                'mobile' => $poc['mobile'] ?? '',
                'email' => $poc['email'] ?? null,
            ])
            ->values();

        // Replace the full set on every save.
        $organisation->pocs()->delete();

        if ($pocs->isNotEmpty()) {
            $organisation->pocs()->createMany($pocs->all());
        }
    }
}
