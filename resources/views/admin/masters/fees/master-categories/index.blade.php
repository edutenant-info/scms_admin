@extends('admin.layouts.master', ['title' => 'Master Categories'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">Fees <i class="fa-solid fa-chevron-right"></i> Master Categories</div>
            <div class="pt">Master Categories</div>
            <div class="pst">Manage Master Categories used across institutions</div>
        </div>
        <div style="display:flex;gap:7px;">
            <a href="{{ route('admin.master-categories.create') }}" class="btn ba"><i class="fa-solid fa-plus"></i> New Master Category</a>
        </div>
    </div>

    <div class="cd">
        <div class="ch">
            <form method="GET" action="{{ route('admin.master-categories.index') }}" class="msrc">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search name…">
            </form>
            <span style="font-size:12px;color:var(--t3);">{{ $items->total() }} total</span>
        </div>
        <div class="tw">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td style="color:var(--t1);font-weight:500;">{{ $item->name }}</td>
                            <td>{{ $item->description ?? '—' }}</td>
                            <td>
                                @if ($item->is_active)
                                    <span class="bdg bg-act">Active</span>
                                @else
                                    <span class="bdg bg-ina">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="ta">
                                    <a href="{{ route('admin.master-categories.edit', $item) }}" class="bi" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    <form method="POST" action="{{ route('admin.master-categories.destroy', $item) }}"
                                          onsubmit="return confirm('Delete Master Category &quot;{{ $item->name }}&quot;?');"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bi dng" title="Delete"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center;padding:32px;color:var(--t3);">
                                No Master Categories yet. <a href="{{ route('admin.master-categories.create') }}" style="color:var(--acc);">Create the first one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($items->hasPages())
        <div style="margin-top:16px;">{{ $items->links() }}</div>
    @endif
</div>
@endsection
