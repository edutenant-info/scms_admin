<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Demographic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Demographic\StoreCasteRequest;
use App\Models\Caste;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CasteController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = Caste::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.demographic.castes.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.demographic.castes.create', [
            'item' => new Caste(['is_active' => true]),
        ]);
    }

    public function store(StoreCasteRequest $request): RedirectResponse
    {
        $item = Caste::create($request->validated());

        return redirect()
            ->route('admin.castes.index')
            ->with('status', 'Caste "'.$item->name.'" created successfully.');
    }

    public function edit(Caste $caste): View
    {
        return view('admin.masters.demographic.castes.edit', ['item' => $caste]);
    }

    public function update(StoreCasteRequest $request, Caste $caste): RedirectResponse
    {
        $caste->update($request->validated());

        return redirect()
            ->route('admin.castes.index')
            ->with('status', 'Caste "'.$caste->name.'" updated successfully.');
    }

    public function destroy(Caste $caste): RedirectResponse
    {
        $name = $caste->name;
        $caste->delete();

        return redirect()
            ->route('admin.castes.index')
            ->with('status', 'Caste "'.$name.'" deleted successfully.');
    }
}
