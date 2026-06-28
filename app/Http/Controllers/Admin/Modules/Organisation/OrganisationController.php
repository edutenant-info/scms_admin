<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Modules\Organisation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Organisation\StoreOrganisationRequest;
use App\Http\Requests\Admin\Organisation\UpdateOrganisationRequest;
use App\Models\Organisation;
use App\Services\Organisation\OrganisationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrganisationController extends Controller
{
    public function __construct(
        private readonly OrganisationService $organisations,
    ) {
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $organisations = $this->organisations->paginate($search !== '' ? $search : null);

        return view('admin.modules.organisation.index', compact('organisations', 'search'));
    }

    public function create(): View
    {
        return view('admin.modules.organisation.create', [
            'organisation' => new Organisation(),
        ]);
    }

    public function store(StoreOrganisationRequest $request): RedirectResponse
    {
        $organisation = $this->organisations->create($request->validated());

        return redirect()
            ->route('admin.organisations.show', $organisation)
            ->with('status', "Organisation \"{$organisation->name}\" created successfully.");
    }

    public function show(Organisation $organisation): View
    {
        $organisation->load(['address', 'pocs', 'institutions']);

        return view('admin.modules.organisation.show', compact('organisation'));
    }

    public function edit(Organisation $organisation): View
    {
        $organisation->load(['address', 'pocs']);

        return view('admin.modules.organisation.edit', compact('organisation'));
    }

    public function update(UpdateOrganisationRequest $request, Organisation $organisation): RedirectResponse
    {
        $this->organisations->update($organisation, $request->validated());

        return redirect()
            ->route('admin.organisations.show', $organisation)
            ->with('status', "Organisation \"{$organisation->name}\" updated successfully.");
    }

    public function destroy(Organisation $organisation): RedirectResponse
    {
        $name = $organisation->name;
        $this->organisations->delete($organisation);

        return redirect()
            ->route('admin.organisations.index')
            ->with('status', "Organisation \"{$name}\" deleted successfully.");
    }
}
