<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Fees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Fees\StoreGeneralCategoryRequest;
use App\Models\GeneralCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GeneralCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = GeneralCategory::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.fees.general-categories.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.fees.general-categories.create', [
            'item' => new GeneralCategory(['is_active' => true]),
        ]);
    }

    public function store(StoreGeneralCategoryRequest $request): RedirectResponse
    {
        $item = GeneralCategory::create($request->validated());

        return redirect()
            ->route('admin.general-categories.index')
            ->with('status', 'General Category "'.$item->name.'" created successfully.');
    }

    public function edit(GeneralCategory $generalCategory): View
    {
        return view('admin.masters.fees.general-categories.edit', ['item' => $generalCategory]);
    }

    public function update(StoreGeneralCategoryRequest $request, GeneralCategory $generalCategory): RedirectResponse
    {
        $generalCategory->update($request->validated());

        return redirect()
            ->route('admin.general-categories.index')
            ->with('status', 'General Category "'.$generalCategory->name.'" updated successfully.');
    }

    public function destroy(GeneralCategory $generalCategory): RedirectResponse
    {
        $name = $generalCategory->name;
        $generalCategory->delete();

        return redirect()
            ->route('admin.general-categories.index')
            ->with('status', 'General Category "'.$name.'" deleted successfully.');
    }
}
