<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Academic\StoreSubjectRequest;
use App\Models\Subject;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = Subject::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.academic.subjects.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.academic.subjects.create', [
            'item' => new Subject(['is_active' => true]),
        ]);
    }

    public function store(StoreSubjectRequest $request): RedirectResponse
    {
        $item = Subject::create($request->validated());

        return redirect()
            ->route('admin.subjects.index')
            ->with('status', 'Subject "'.$item->name.'" created successfully.');
    }

    public function edit(Subject $subject): View
    {
        return view('admin.masters.academic.subjects.edit', ['item' => $subject]);
    }

    public function update(StoreSubjectRequest $request, Subject $subject): RedirectResponse
    {
        $subject->update($request->validated());

        return redirect()
            ->route('admin.subjects.index')
            ->with('status', 'Subject "'.$subject->name.'" updated successfully.');
    }

    public function destroy(Subject $subject): RedirectResponse
    {
        $name = $subject->name;
        $subject->delete();

        return redirect()
            ->route('admin.subjects.index')
            ->with('status', 'Subject "'.$name.'" deleted successfully.');
    }
}
