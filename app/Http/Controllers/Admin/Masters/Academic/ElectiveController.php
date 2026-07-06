<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Academic\StoreElectiveRequest;
use App\Models\Elective;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ElectiveController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = Elective::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.academic.electives.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.academic.electives.create', [
            'item' => new Elective(['is_active' => true]),
        ]);
    }

    public function store(StoreElectiveRequest $request): RedirectResponse
    {
        $item = Elective::create($request->validated());

        return redirect()
            ->route('admin.electives.index')
            ->with('status', 'Elective "'.$item->name.'" created successfully.');
    }

    public function edit(Elective $elective): View
    {
        return view('admin.masters.academic.electives.edit', ['item' => $elective]);
    }

    public function update(StoreElectiveRequest $request, Elective $elective): RedirectResponse
    {
        $elective->update($request->validated());

        return redirect()
            ->route('admin.electives.index')
            ->with('status', 'Elective "'.$elective->name.'" updated successfully.');
    }

    public function destroy(Elective $elective): RedirectResponse
    {
        $name = $elective->name;
        $elective->delete();

        return redirect()
            ->route('admin.electives.index')
            ->with('status', 'Elective "'.$name.'" deleted successfully.');
    }
}
