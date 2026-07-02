<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Academic\StoreAcademicYearRequest;
use App\Models\AcademicYear;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = AcademicYear::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.academic.academic-years.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.academic.academic-years.create', [
            'item' => new AcademicYear(['is_active' => true]),
        ]);
    }

    public function store(StoreAcademicYearRequest $request): RedirectResponse
    {
        $item = AcademicYear::create($request->validated());

        return redirect()
            ->route('admin.academic-years.index')
            ->with('status', 'Academic Year "'.$item->name.'" created successfully.');
    }

    public function edit(AcademicYear $academicYear): View
    {
        return view('admin.masters.academic.academic-years.edit', ['item' => $academicYear]);
    }

    public function update(StoreAcademicYearRequest $request, AcademicYear $academicYear): RedirectResponse
    {
        $academicYear->update($request->validated());

        return redirect()
            ->route('admin.academic-years.index')
            ->with('status', 'Academic Year "'.$academicYear->name.'" updated successfully.');
    }

    public function destroy(AcademicYear $academicYear): RedirectResponse
    {
        $name = $academicYear->name;
        $academicYear->delete();

        return redirect()
            ->route('admin.academic-years.index')
            ->with('status', 'Academic Year "'.$name.'" deleted successfully.');
    }
}
