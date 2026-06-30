@extends('admin.layouts.master', ['title' => 'Institutions'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">Modules <i class="fa-solid fa-chevron-right"></i> Institutions</div>
            <div class="pt">Institutions</div>
            <div class="pst">Manage institutions across all organisations</div>
        </div>
        <div style="display:flex;gap:7px;">
            <a href="{{ route('admin.institutions.create') }}" class="btn ba"><i class="fa-solid fa-plus"></i> New Institution</a>
        </div>
    </div>

    <div class="cd">
        <div class="ch">
            <form method="GET" action="{{ route('admin.institutions.index') }}" class="msrc">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search name, slug, organisation…">
            </form>
            <span style="font-size:12px;color:var(--t3);">{{ $institutions->total() }} total</span>
        </div>
        <div class="tw">
            <table>
                <thead>
                    <tr>
                        <th>Institution</th>
                        <th>Organisation</th>
                        <th>Type</th>
                        <th>Board</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($institutions as $institution)
                        @php
                            $initials = strtoupper(mb_substr($institution->name, 0, 2));
                        @endphp
                        <tr>
                            <td>
                                <div class="to">
                                    <div class="toa" style="background:linear-gradient(135deg,var(--acc),#818CF8);">{{ $initials }}</div>
                                    <div>
                                        <div class="ton">{{ $institution->name }}</div>
                                        <div style="font-size:10px;color:var(--t3);">{{ $institution->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $institution->organisation->name ?? '—' }}</td>
                            <td>
                                @if ($institution->institutionType)
                                    <span class="bp2 bp-ac">{{ $institution->institutionType->name }}</span>
                                @else
                                    <span style="color:var(--t3);">—</span>
                                @endif
                            </td>
                            <td>
                                @if ($institution->board)
                                    <span class="bp2 bp-gr">{{ $institution->board->name }}</span>
                                @else
                                    <span style="color:var(--t3);">—</span>
                                @endif
                            </td>
                            <td>
                                @if ($institution->is_active)
                                    <span class="bdg bg-act">Active</span>
                                @else
                                    <span class="bdg bg-ina">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="ta">
                                    <a href="{{ route('admin.institutions.show', $institution) }}" class="bi" title="View"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('admin.institutions.edit', $institution) }}" class="bi" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    <form method="POST" action="{{ route('admin.institutions.destroy', $institution) }}"
                                          onsubmit="return confirm('Delete institution &quot;{{ $institution->name }}&quot;?');"
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
                            <td colspan="6" style="text-align:center;padding:32px;color:var(--t3);">
                                No institutions found. <a href="{{ route('admin.institutions.create') }}" style="color:var(--acc);">Create the first one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($institutions->hasPages())
        <div style="margin-top:16px;">
            {{ $institutions->links() }}
        </div>
    @endif
</div>
@endsection
