<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Demographic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Demographic\StoreLanguageRequest;
use App\Models\Language;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = Language::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.demographic.languages.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.demographic.languages.create', [
            'item' => new Language(['is_active' => true]),
        ]);
    }

    public function store(StoreLanguageRequest $request): RedirectResponse
    {
        $item = Language::create($request->validated());

        return redirect()
            ->route('admin.languages.index')
            ->with('status', 'Language "'.$item->name.'" created successfully.');
    }

    public function edit(Language $language): View
    {
        return view('admin.masters.demographic.languages.edit', ['item' => $language]);
    }

    public function update(StoreLanguageRequest $request, Language $language): RedirectResponse
    {
        $language->update($request->validated());

        return redirect()
            ->route('admin.languages.index')
            ->with('status', 'Language "'.$language->name.'" updated successfully.');
    }

    public function destroy(Language $language): RedirectResponse
    {
        $name = $language->name;
        $language->delete();

        return redirect()
            ->route('admin.languages.index')
            ->with('status', 'Language "'.$name.'" deleted successfully.');
    }
}
