<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Masters\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\Academic\StoreStreamRequest;
use App\Models\Stream;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StreamController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $items = Stream::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.masters.academic.streams.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.masters.academic.streams.create', [
            'item' => new Stream(['is_active' => true]),
        ]);
    }

    public function store(StoreStreamRequest $request): RedirectResponse
    {
        $item = Stream::create($request->validated());

        return redirect()
            ->route('admin.streams.index')
            ->with('status', 'Stream "'.$item->name.'" created successfully.');
    }

    public function edit(Stream $stream): View
    {
        return view('admin.masters.academic.streams.edit', ['item' => $stream]);
    }

    public function update(StoreStreamRequest $request, Stream $stream): RedirectResponse
    {
        $stream->update($request->validated());

        return redirect()
            ->route('admin.streams.index')
            ->with('status', 'Stream "'.$stream->name.'" updated successfully.');
    }

    public function destroy(Stream $stream): RedirectResponse
    {
        $name = $stream->name;
        $stream->delete();

        return redirect()
            ->route('admin.streams.index')
            ->with('status', 'Stream "'.$name.'" deleted successfully.');
    }
}
