<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Academic\StoreStandardRequest;
use App\Models\Standard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StandardController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = Standard::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.academic.standards.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.academic.standards.create', [
            'item' => new Standard(['is_active' => true]),
        ]);
    }

    public function store(StoreStandardRequest $request): RedirectResponse
    {
        $item = Standard::create($request->validated());

        return redirect()
            ->route('admin.standards.index')
            ->with('status', 'Standard "'.$item->name.'" created successfully.');
    }

    public function edit(Standard $standard): View
    {
        return view('admin.masters.academic.standards.edit', ['item' => $standard]);
    }

    public function update(StoreStandardRequest $request, Standard $standard): RedirectResponse
    {
        $standard->update($request->validated());

        return redirect()
            ->route('admin.standards.index')
            ->with('status', 'Standard "'.$standard->name.'" updated successfully.');
    }

    public function destroy(Standard $standard): RedirectResponse
    {
        $name = $standard->name;
        $standard->delete();

        return redirect()
            ->route('admin.standards.index')
            ->with('status', 'Standard "'.$name.'" deleted successfully.');
    }
}
