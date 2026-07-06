<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Mappings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Mappings\StoreInstitutionFeeTypeRequest;
use App\Models\FeeType;
use App\Models\Institution;
use App\Models\InstitutionFeeType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InstitutionFeeTypeController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = InstitutionFeeType::query()
            ->with(['institution:id,name', 'feeType:id,name'])
            ->when($search !== '', fn ($query) => $query->where(function ($q) use ($search) {
                $q->whereHas('institution', fn ($iq) => $iq->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('feeType', fn ($fq) => $fq->where('name', 'like', "%{$search}%"));
            }))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.mappings.institution-fee-types.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.mappings.institution-fee-types.create', [
            'item' => new InstitutionFeeType(['is_active' => true]),
            ...$this->options(),
        ]);
    }

    public function store(StoreInstitutionFeeTypeRequest $request): RedirectResponse
    {
        $item = InstitutionFeeType::create($request->validated());
        $item->load(['institution:id,name', 'feeType:id,name']);

        return redirect()
            ->route('admin.institution-fee-types.index')
            ->with('status', 'Mapping "'.$item->institution->name.' → '.$item->feeType->name.'" created successfully.');
    }

    public function edit(InstitutionFeeType $institutionFeeType): View
    {
        return view('admin.masters.mappings.institution-fee-types.edit', [
            'item' => $institutionFeeType,
            ...$this->options(),
        ]);
    }

    public function update(StoreInstitutionFeeTypeRequest $request, InstitutionFeeType $institutionFeeType): RedirectResponse
    {
        $institutionFeeType->update($request->validated());
        $institutionFeeType->load(['institution:id,name', 'feeType:id,name']);

        return redirect()
            ->route('admin.institution-fee-types.index')
            ->with('status', 'Mapping "'.$institutionFeeType->institution->name.' → '.$institutionFeeType->feeType->name.'" updated successfully.');
    }

    public function destroy(InstitutionFeeType $institutionFeeType): RedirectResponse
    {
        $institutionFeeType->load(['institution:id,name', 'feeType:id,name']);
        $label = $institutionFeeType->institution->name.' → '.$institutionFeeType->feeType->name;
        $institutionFeeType->delete();

        return redirect()
            ->route('admin.institution-fee-types.index')
            ->with('status', 'Mapping "'.$label.'" deleted successfully.');
    }

    /**
     * @return array<string, \Illuminate\Support\Collection>
     */
    private function options(): array
    {
        return [
            'institutions' => Institution::query()->orderBy('name')->pluck('name', 'id'),
            'feeTypes' => FeeType::query()->orderBy('name')->pluck('name', 'id'),
        ];
    }
}
