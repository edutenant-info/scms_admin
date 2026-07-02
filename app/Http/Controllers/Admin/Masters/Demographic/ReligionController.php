<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Demographic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Demographic\StoreReligionRequest;
use App\Models\Religion;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReligionController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = Religion::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.demographic.religions.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.demographic.religions.create', [
            'item' => new Religion(['is_active' => true]),
        ]);
    }

    public function store(StoreReligionRequest $request): RedirectResponse
    {
        $item = Religion::create($request->validated());

        return redirect()
            ->route('admin.religions.index')
            ->with('status', 'Religion "'.$item->name.'" created successfully.');
    }

    public function edit(Religion $religion): View
    {
        return view('admin.masters.demographic.religions.edit', ['item' => $religion]);
    }

    public function update(StoreReligionRequest $request, Religion $religion): RedirectResponse
    {
        $religion->update($request->validated());

        return redirect()
            ->route('admin.religions.index')
            ->with('status', 'Religion "'.$religion->name.'" updated successfully.');
    }

    public function destroy(Religion $religion): RedirectResponse
    {
        $name = $religion->name;
        $religion->delete();

        return redirect()
            ->route('admin.religions.index')
            ->with('status', 'Religion "'.$name.'" deleted successfully.');
    }
}
