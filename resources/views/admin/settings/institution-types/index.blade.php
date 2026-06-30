@extends('admin.layouts.master', ['title' => 'Institution Types'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">Settings <i class="fa-solid fa-chevron-right"></i> Institution Types</div>
            <div class="pt">Institution Types</div>
            <div class="pst">Categories used when registering institutions</div>
        </div>
        <div style="display:flex;gap:7px;">
            <a href="{{ route('admin.institution-types.create') }}" class="btn ba"><i class="fa-solid fa-plus"></i> New Type</a>
        </div>
    </div>

    <div class="cd">
        <div class="ch">
            <form method="GET" action="{{ route('admin.institution-types.index') }}" class="msrc">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search name…">
            </form>
            <span style="font-size:12px;color:var(--t3);">{{ $types->total() }} total</span>
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
                    @forelse ($types as $type)
                        <tr>
                            <td style="color:var(--t1);font-weight:500;">{{ $type->name }}</td>
                            <td>{{ $type->description ?? '—' }}</td>
                            <td>
                                @if ($type->is_active)
                                    <span class="bdg bg-act">Active</span>
                                @else
                                    <span class="bdg bg-ina">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="ta">
                                    <a href="{{ route('admin.institution-types.edit', $type) }}" class="bi" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    <form method="POST" action="{{ route('admin.institution-types.destroy', $type) }}"
                                          onsubmit="return confirm('Delete institution type &quot;{{ $type->name }}&quot;?');"
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
                                No institution types yet. <a href="{{ route('admin.institution-types.create') }}" style="color:var(--acc);">Create the first one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($types->hasPages())
        <div style="margin-top:16px;">{{ $types->links() }}</div>
    @endif
</div>
@endsection
