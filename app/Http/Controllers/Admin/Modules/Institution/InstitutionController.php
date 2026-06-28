<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Modules\Institution;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Institution\StoreInstitutionRequest;
use App\Http\Requests\Admin\Institution\UpdateInstitutionRequest;
use App\Models\Institution;
use App\Services\Institution\InstitutionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function __construct(
        private readonly InstitutionService $institutions,
    ) {
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $institutions = $this->institutions->paginate($search !== '' ? $search : null);

        return view('admin.modules.institution.index', compact('institutions', 'search'));
    }

    public function create(): View
    {
        return view('admin.modules.institution.create', [
            'institution' => new Institution(),
            'organisations' => $this->institutions->organisationOptions(),
        ]);
    }

    public function store(StoreInstitutionRequest $request): RedirectResponse
    {
        $institution = $this->institutions->create($request->validated());

        return redirect()
            ->route('admin.institutions.show', $institution)
            ->with('status', "Institution \"{$institution->name}\" created successfully.");
    }

    public function show(Institution $institution): View
    {
        $institution->load(['organisation', 'institutionAddress']);

        return view('admin.modules.institution.show', compact('institution'));
    }

    public function edit(Institution $institution): View
    {
        $institution->load(['institutionAddress']);

        return view('admin.modules.institution.edit', [
            'institution' => $institution,
            'organisations' => $this->institutions->organisationOptions(),
        ]);
    }

    public function update(UpdateInstitutionRequest $request, Institution $institution): RedirectResponse
    {
        $this->institutions->update($institution, $request->validated());

        return redirect()
            ->route('admin.institutions.show', $institution)
            ->with('status', "Institution \"{$institution->name}\" updated successfully.");
    }

    public function destroy(Institution $institution): RedirectResponse
    {
        $name = $institution->name;
        $this->institutions->delete($institution);

        return redirect()
            ->route('admin.institutions.index')
            ->with('status', "Institution \"{$name}\" deleted successfully.");
    }
}
