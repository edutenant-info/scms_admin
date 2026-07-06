<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Mappings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Mappings\StoreInstitutionAcademicYearRequest;
use App\Models\AcademicYear;
use App\Models\Institution;
use App\Models\InstitutionAcademicYear;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InstitutionAcademicYearController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = InstitutionAcademicYear::query()
            ->with(['institution:id,name', 'academicYear:id,name'])
            ->when($search !== '', fn ($query) => $query->where(function ($q) use ($search) {
                $q->whereHas('institution', fn ($iq) => $iq->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('academicYear', fn ($aq) => $aq->where('name', 'like', "%{$search}%"));
            }))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.mappings.institution-academic-years.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.mappings.institution-academic-years.create', [
            'item' => new InstitutionAcademicYear(['is_active' => true]),
            ...$this->options(),
        ]);
    }

    public function store(StoreInstitutionAcademicYearRequest $request): RedirectResponse
    {
        $item = InstitutionAcademicYear::create($request->validated());
        $item->load(['institution:id,name', 'academicYear:id,name']);

        return redirect()
            ->route('admin.institution-academic-years.index')
            ->with('status', 'Mapping "'.$item->institution->name.' → '.$item->academicYear->name.'" created successfully.');
    }

    public function edit(InstitutionAcademicYear $institutionAcademicYear): View
    {
        return view('admin.masters.mappings.institution-academic-years.edit', [
            'item' => $institutionAcademicYear,
            ...$this->options(),
        ]);
    }

    public function update(StoreInstitutionAcademicYearRequest $request, InstitutionAcademicYear $institutionAcademicYear): RedirectResponse
    {
        $institutionAcademicYear->update($request->validated());
        $institutionAcademicYear->load(['institution:id,name', 'academicYear:id,name']);

        return redirect()
            ->route('admin.institution-academic-years.index')
            ->with('status', 'Mapping "'.$institutionAcademicYear->institution->name.' → '.$institutionAcademicYear->academicYear->name.'" updated successfully.');
    }

    public function destroy(InstitutionAcademicYear $institutionAcademicYear): RedirectResponse
    {
        $institutionAcademicYear->load(['institution:id,name', 'academicYear:id,name']);
        $label = $institutionAcademicYear->institution->name.' → '.$institutionAcademicYear->academicYear->name;
        $institutionAcademicYear->delete();

        return redirect()
            ->route('admin.institution-academic-years.index')
            ->with('status', 'Mapping "'.$label.'" deleted successfully.');
    }

    /**
     * @return array<string, \Illuminate\Support\Collection>
     */
    private function options(): array
    {
        return [
            'institutions' => Institution::query()->orderBy('name')->pluck('name', 'id'),
            'academicYears' => AcademicYear::query()->orderBy('name')->pluck('name', 'id'),
        ];
    }
}
