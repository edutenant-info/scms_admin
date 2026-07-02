<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Academic\StoreSectionRequest;
use App\Models\Section;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = Section::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.academic.sections.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.academic.sections.create', [
            'item' => new Section(['is_active' => true]),
        ]);
    }

    public function store(StoreSectionRequest $request): RedirectResponse
    {
        $item = Section::create($request->validated());

        return redirect()
            ->route('admin.sections.index')
            ->with('status', 'Section "'.$item->name.'" created successfully.');
    }

    public function edit(Section $section): View
    {
        return view('admin.masters.academic.sections.edit', ['item' => $section]);
    }

    public function update(StoreSectionRequest $request, Section $section): RedirectResponse
    {
        $section->update($request->validated());

        return redirect()
            ->route('admin.sections.index')
            ->with('status', 'Section "'.$section->name.'" updated successfully.');
    }

    public function destroy(Section $section): RedirectResponse
    {
        $name = $section->name;
        $section->delete();

        return redirect()
            ->route('admin.sections.index')
            ->with('status', 'Section "'.$name.'" deleted successfully.');
    }
}
