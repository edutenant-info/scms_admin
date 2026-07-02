<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Demographic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Demographic\StoreNationalityRequest;
use App\Models\Nationality;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NationalityController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = Nationality::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.demographic.nationalities.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.demographic.nationalities.create', [
            'item' => new Nationality(['is_active' => true]),
        ]);
    }

    public function store(StoreNationalityRequest $request): RedirectResponse
    {
        $item = Nationality::create($request->validated());

        return redirect()
            ->route('admin.nationalities.index')
            ->with('status', 'Nationality "'.$item->name.'" created successfully.');
    }

    public function edit(Nationality $nationality): View
    {
        return view('admin.masters.demographic.nationalities.edit', ['item' => $nationality]);
    }

    public function update(StoreNationalityRequest $request, Nationality $nationality): RedirectResponse
    {
        $nationality->update($request->validated());

        return redirect()
            ->route('admin.nationalities.index')
            ->with('status', 'Nationality "'.$nationality->name.'" updated successfully.');
    }

    public function destroy(Nationality $nationality): RedirectResponse
    {
        $name = $nationality->name;
        $nationality->delete();

        return redirect()
            ->route('admin.nationalities.index')
            ->with('status', 'Nationality "'.$name.'" deleted successfully.');
    }
}
