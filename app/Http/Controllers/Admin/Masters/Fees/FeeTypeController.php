<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Fees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Fees\StoreFeeTypeRequest;
use App\Models\FeeType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FeeTypeController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = FeeType::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.fees.fee-types.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.fees.fee-types.create', [
            'item' => new FeeType(['is_active' => true]),
        ]);
    }

    public function store(StoreFeeTypeRequest $request): RedirectResponse
    {
        $item = FeeType::create($request->validated());

        return redirect()
            ->route('admin.fee-types.index')
            ->with('status', 'Fee Type "'.$item->name.'" created successfully.');
    }

    public function edit(FeeType $feeType): View
    {
        return view('admin.masters.fees.fee-types.edit', ['item' => $feeType]);
    }

    public function update(StoreFeeTypeRequest $request, FeeType $feeType): RedirectResponse
    {
        $feeType->update($request->validated());

        return redirect()
            ->route('admin.fee-types.index')
            ->with('status', 'Fee Type "'.$feeType->name.'" updated successfully.');
    }

    public function destroy(FeeType $feeType): RedirectResponse
    {
        $name = $feeType->name;
        $feeType->delete();

        return redirect()
            ->route('admin.fee-types.index')
            ->with('status', 'Fee Type "'.$name.'" deleted successfully.');
    }
}
