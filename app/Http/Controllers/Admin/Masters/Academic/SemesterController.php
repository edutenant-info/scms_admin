<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Academic\StoreSemesterRequest;
use App\Models\Semester;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = Semester::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.academic.semesters.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.academic.semesters.create', [
            'item' => new Semester(['is_active' => true]),
        ]);
    }

    public function store(StoreSemesterRequest $request): RedirectResponse
    {
        $item = Semester::create($request->validated());

        return redirect()
            ->route('admin.semesters.index')
            ->with('status', 'Semester "'.$item->name.'" created successfully.');
    }

    public function edit(Semester $semester): View
    {
        return view('admin.masters.academic.semesters.edit', ['item' => $semester]);
    }

    public function update(StoreSemesterRequest $request, Semester $semester): RedirectResponse
    {
        $semester->update($request->validated());

        return redirect()
            ->route('admin.semesters.index')
            ->with('status', 'Semester "'.$semester->name.'" updated successfully.');
    }

    public function destroy(Semester $semester): RedirectResponse
    {
        $name = $semester->name;
        $semester->delete();

        return redirect()
            ->route('admin.semesters.index')
            ->with('status', 'Semester "'.$name.'" deleted successfully.');
    }
}
