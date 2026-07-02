<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Academic\StoreCombinationRequest;
use App\Models\Combination;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CombinationController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = Combination::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.academic.combinations.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.academic.combinations.create', [
            'item' => new Combination(['is_active' => true]),
        ]);
    }

    public function store(StoreCombinationRequest $request): RedirectResponse
    {
        $item = Combination::create($request->validated());

        return redirect()
            ->route('admin.combinations.index')
            ->with('status', 'Combination "'.$item->name.'" created successfully.');
    }

    public function edit(Combination $combination): View
    {
        return view('admin.masters.academic.combinations.edit', ['item' => $combination]);
    }

    public function update(StoreCombinationRequest $request, Combination $combination): RedirectResponse
    {
        $combination->update($request->validated());

        return redirect()
            ->route('admin.combinations.index')
            ->with('status', 'Combination "'.$combination->name.'" updated successfully.');
    }

    public function destroy(Combination $combination): RedirectResponse
    {
        $name = $combination->name;
        $combination->delete();

        return redirect()
            ->route('admin.combinations.index')
            ->with('status', 'Combination "'.$name.'" deleted successfully.');
    }
}
