<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Fees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Fees\StoreMasterCategoryRequest;
use App\Models\MasterCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MasterCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = MasterCategory::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.fees.master-categories.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.fees.master-categories.create', [
            'item' => new MasterCategory(['is_active' => true]),
        ]);
    }

    public function store(StoreMasterCategoryRequest $request): RedirectResponse
    {
        $item = MasterCategory::create($request->validated());

        return redirect()
            ->route('admin.master-categories.index')
            ->with('status', 'Master Category "'.$item->name.'" created successfully.');
    }

    public function edit(MasterCategory $masterCategory): View
    {
        return view('admin.masters.fees.master-categories.edit', ['item' => $masterCategory]);
    }

    public function update(StoreMasterCategoryRequest $request, MasterCategory $masterCategory): RedirectResponse
    {
        $masterCategory->update($request->validated());

        return redirect()
            ->route('admin.master-categories.index')
            ->with('status', 'Master Category "'.$masterCategory->name.'" updated successfully.');
    }

    public function destroy(MasterCategory $masterCategory): RedirectResponse
    {
        $name = $masterCategory->name;
        $masterCategory->delete();

        return redirect()
            ->route('admin.master-categories.index')
            ->with('status', 'Master Category "'.$name.'" deleted successfully.');
    }
}
