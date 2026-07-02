<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Demographic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Demographic\StoreBloodGroupRequest;
use App\Models\BloodGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BloodGroupController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = BloodGroup::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.demographic.blood-groups.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.demographic.blood-groups.create', [
            'item' => new BloodGroup(['is_active' => true]),
        ]);
    }

    public function store(StoreBloodGroupRequest $request): RedirectResponse
    {
        $item = BloodGroup::create($request->validated());

        return redirect()
            ->route('admin.blood-groups.index')
            ->with('status', 'Blood Group "'.$item->name.'" created successfully.');
    }

    public function edit(BloodGroup $bloodGroup): View
    {
        return view('admin.masters.demographic.blood-groups.edit', ['item' => $bloodGroup]);
    }

    public function update(StoreBloodGroupRequest $request, BloodGroup $bloodGroup): RedirectResponse
    {
        $bloodGroup->update($request->validated());

        return redirect()
            ->route('admin.blood-groups.index')
            ->with('status', 'Blood Group "'.$bloodGroup->name.'" updated successfully.');
    }

    public function destroy(BloodGroup $bloodGroup): RedirectResponse
    {
        $name = $bloodGroup->name;
        $bloodGroup->delete();

        return redirect()
            ->route('admin.blood-groups.index')
            ->with('status', 'Blood Group "'.$name.'" deleted successfully.');
    }
}
