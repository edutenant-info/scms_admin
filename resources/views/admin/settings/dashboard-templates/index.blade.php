@extends('admin.layouts.master', ['title' => 'Dashboard Templates'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">Settings <i class="fa-solid fa-chevron-right"></i> Dashboard Templates</div>
            <div class="pt">Dashboard Templates</div>
            <div class="pst">Templates available for organisation dashboards</div>
        </div>
        <div style="display:flex;gap:7px;">
            <a href="{{ route('admin.dashboard-templates.create') }}" class="btn ba"><i class="fa-solid fa-plus"></i> New Template</a>
        </div>
    </div>

    <div class="cd">
        <div class="ch">
            <form method="GET" action="{{ route('admin.dashboard-templates.index') }}" class="msrc">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search name or code…">
            </form>
            <span style="font-size:12px;color:var(--t3);">{{ $templates->total() }} total</span>
        </div>
        <div class="tw">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($templates as $template)
                        <tr>
                            <td style="color:var(--t1);font-weight:500;">{{ $template->name }}</td>
                            <td><code>{{ $template->code }}</code></td>
                            <td>{{ $template->description ?? '—' }}</td>
                            <td>
                                @if ($template->is_active)
                                    <span class="bdg bg-act">Active</span>
                                @else
                                    <span class="bdg bg-ina">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="ta">
                                    <a href="{{ route('admin.dashboard-templates.edit', $template) }}" class="bi" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    <form method="POST" action="{{ route('admin.dashboard-templates.destroy', $template) }}"
                                          onsubmit="return confirm('Delete dashboard template &quot;{{ $template->name }}&quot;?');"
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
                            <td colspan="5" style="text-align:center;padding:32px;color:var(--t3);">
                                No dashboard templates yet. <a href="{{ route('admin.dashboard-templates.create') }}" style="color:var(--acc);">Create the first one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($templates->hasPages())
        <div style="margin-top:16px;">{{ $templates->links() }}</div>
    @endif
</div>
@endsection
