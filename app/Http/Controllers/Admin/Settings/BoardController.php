<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\StoreBoardRequest;
use App\Models\Board;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $boards = Board::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.settings.boards.index', compact('boards', 'search'));
    }

    public function create(): View
    {
        return view('admin.settings.boards.create', [
            'board' => new Board(['is_active' => true]),
        ]);
    }

    public function store(StoreBoardRequest $request): RedirectResponse
    {
        $board = Board::create($request->validated());

        return redirect()
            ->route('admin.boards.index')
            ->with('status', "Board \"{$board->name}\" created successfully.");
    }

    public function edit(Board $board): View
    {
        return view('admin.settings.boards.edit', ['board' => $board]);
    }

    public function update(StoreBoardRequest $request, Board $board): RedirectResponse
    {
        $board->update($request->validated());

        return redirect()
            ->route('admin.boards.index')
            ->with('status', "Board \"{$board->name}\" updated successfully.");
    }

    public function destroy(Board $board): RedirectResponse
    {
        $name = $board->name;
        $board->delete();

        return redirect()
            ->route('admin.boards.index')
            ->with('status', "Board \"{$name}\" deleted successfully.");
    }
}
