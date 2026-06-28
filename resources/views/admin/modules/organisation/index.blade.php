@extends('admin.layouts.master', ['title' => 'Organisations'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">Modules <i class="fa-solid fa-chevron-right"></i> Organisations</div>
            <div class="pt">Organisations</div>
            <div class="pst">Manage tenant organisations across the platform</div>
        </div>
        <div style="display:flex;gap:7px;">
            <a href="{{ route('admin.organisations.create') }}" class="btn ba"><i class="fa-solid fa-plus"></i> New Organisation</a>
        </div>
    </div>

    <div class="cd">
        <div class="ch">
            <form method="GET" action="{{ route('admin.organisations.index') }}" class="msrc">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search name, slug, email…">
            </form>
            <span style="font-size:12px;color:var(--t3);">{{ $organisations->total() }} total</span>
        </div>
        <div class="tw">
            <table>
                <thead>
                    <tr>
                        <th>Organisation</th>
                        <th>Contact</th>
                        <th>Institutions</th>
                        <th>Plan</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($organisations as $organisation)
                        @php
                            $meta = $organisation->metadata ?? [];
                            $initials = strtoupper(mb_substr($organisation->name, 0, 2));
                        @endphp
                        <tr>
                            <td>
                                <div class="to">
                                    <div class="toa" style="background:linear-gradient(135deg,var(--acc),#818CF8);">{{ $initials }}</div>
                                    <div>
                                        <div class="ton">{{ $organisation->name }}</div>
                                        <div style="font-size:10px;color:var(--t3);">{{ $organisation->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>{{ $organisation->email }}</div>
                                <div style="font-size:10px;color:var(--t3);">{{ $organisation->mobile }}</div>
                            </td>
                            <td>{{ $organisation->institutions_count }}</td>
                            <td>
                                @if (!empty($meta['plan']))
                                    <span class="bp2 bp-ac">{{ $meta['plan'] }}</span>
                                @else
                                    <span style="color:var(--t3);">—</span>
                                @endif
                            </td>
                            <td>
                                @if ($organisation->is_active)
                                    <span class="bdg bg-act">Active</span>
                                @else
                                    <span class="bdg bg-ina">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="ta">
                                    <a href="{{ route('admin.organisations.show', $organisation) }}" class="bi" title="View"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('admin.organisations.edit', $organisation) }}" class="bi" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    <form method="POST" action="{{ route('admin.organisations.destroy', $organisation) }}"
                                          onsubmit="return confirm('Delete organisation &quot;{{ $organisation->name }}&quot;? This can be restored from trash.');"
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
                                No organisations found. <a href="{{ route('admin.organisations.create') }}" style="color:var(--acc);">Create the first one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($organisations->hasPages())
        <div style="margin-top:16px;">
            {{ $organisations->links() }}
        </div>
    @endif
</div>
@endsection
