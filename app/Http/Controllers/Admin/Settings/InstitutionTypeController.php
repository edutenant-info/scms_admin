<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\StoreInstitutionTypeRequest;
use App\Models\InstitutionType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InstitutionTypeController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $types = InstitutionType::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.settings.institution-types.index', compact('types', 'search'));
    }

    public function create(): View
    {
        return view('admin.settings.institution-types.create', [
            'type' => new InstitutionType(['is_active' => true]),
        ]);
    }

    public function store(StoreInstitutionTypeRequest $request): RedirectResponse
    {
        $type = InstitutionType::create($request->validated());

        return redirect()
            ->route('admin.institution-types.index')
            ->with('status', "Institution type \"{$type->name}\" created successfully.");
    }

    public function edit(InstitutionType $institutionType): View
    {
        return view('admin.settings.institution-types.edit', ['type' => $institutionType]);
    }

    public function update(StoreInstitutionTypeRequest $request, InstitutionType $institutionType): RedirectResponse
    {
        $institutionType->update($request->validated());

        return redirect()
            ->route('admin.institution-types.index')
            ->with('status', "Institution type \"{$institutionType->name}\" updated successfully.");
    }

    public function destroy(InstitutionType $institutionType): RedirectResponse
    {
        $name = $institutionType->name;
        $institutionType->delete();

        return redirect()
            ->route('admin.institution-types.index')
            ->with('status', "Institution type \"{$name}\" deleted successfully.");
    }
}
