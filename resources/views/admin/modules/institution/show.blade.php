@extends('admin.layouts.master', ['title' => $institution->name])

@section('content')
@php
    $initials = strtoupper(mb_substr($institution->name, 0, 2));
@endphp
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.institutions.index') }}">Institutions</a>
                <i class="fa-solid fa-chevron-right"></i> {{ $institution->name }}
            </div>
            <div class="pt">{{ $institution->name }}</div>
            <div class="pst">{{ $institution->slug }}</div>
        </div>
        <div style="display:flex;gap:7px;">
            <a href="{{ route('admin.institutions.edit', $institution) }}" class="btn ba"><i class="fa-solid fa-pen"></i> Edit</a>
            <form method="POST" action="{{ route('admin.institutions.destroy', $institution) }}"
                  onsubmit="return confirm('Delete this institution?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn bo"><i class="fa-solid fa-trash-can"></i> Delete</button>
            </form>
        </div>
    </div>

    {{-- Header card --}}
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;padding:20px;background:var(--card);border:1px solid var(--bdr);border-radius:var(--r);">
        <div style="width:52px;height:52px;border-radius:13px;background:linear-gradient(135deg,var(--acc),#818CF8);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:700;color:#fff;">{{ $initials }}</div>
        <div style="flex:1;">
            <div style="font-size:20px;">{{ $institution->name }}</div>
            <div style="font-size:12px;color:var(--t3);">{{ $institution->organisation->name ?? '—' }}</div>
        </div>
        <div style="display:flex;gap:7px;align-items:center;">
            @if ($institution->institutionType)<span class="bp2 bp-ac">{{ $institution->institutionType->name }}</span>@endif
            @if ($institution->board)<span class="bp2 bp-gr">{{ $institution->board->name }}</span>@endif
            @if ($institution->is_active)
                <span class="bdg bg-act">Active</span>
            @else
                <span class="bdg bg-ina">Inactive</span>
            @endif
        </div>
    </div>

    <div class="pg">
        {{-- Details --}}
        <div class="cd">
            <div class="ch"><span class="ctit">Details</span></div>
            <div class="cb">
                <div class="tw"><table>
                    <tr><th>Organisation</th><td>{{ $institution->organisation->name ?? '—' }}</td></tr>
                    <tr><th>Slug</th><td>{{ $institution->slug }}</td></tr>
                    <tr><th>Institution Type</th><td>{{ $institution->institutionType->name ?? '—' }}</td></tr>
                    <tr><th>Board</th><td>{{ $institution->board->name ?? '—' }}</td></tr>
                    <tr><th>Email</th><td>{{ $institution->email }}</td></tr>
                    <tr><th>Mobile</th><td>{{ $institution->mobile }}</td></tr>
                    <tr><th>Sub-domain</th><td>{{ $institution->sub_domain ?? '—' }}</td></tr>
                    <tr><th>Domain</th><td>{{ $institution->domain ?? '—' }}</td></tr>
                    <tr><th>Dashboard Template</th><td>{{ $institution->dashboardTemplate->name ?? '—' }}</td></tr>
                    <tr><th>Database Name</th><td>{{ $institution->database_name ?? '—' }}</td></tr>
                    <tr><th>Status</th><td>{{ $institution->is_active ? 'Active' : 'Inactive' }}</td></tr>
                </table></div>
            </div>
        </div>

        {{-- Partners --}}
        <div class="cd">
            <div class="ch"><span class="ctit">Partners</span></div>
            <div class="cb">
                <div class="tw"><table>
                    <tr><th>Zonal Partner</th><td>{{ $institution->zonal_partner_name ?? '—' }}</td></tr>
                </table></div>

                @if ($institution->partners->count())
                    <div class="tw" style="margin-top:12px;"><table>
                        <thead><tr><th>Name</th><th>Designation</th><th>Mobile</th></tr></thead>
                        <tbody>
                            @foreach ($institution->partners as $partner)
                                <tr>
                                    <td>{{ $partner->name }}</td>
                                    <td>{{ $partner->designation ?? '—' }}</td>
                                    <td>{{ $partner->mobile }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table></div>
                @else
                    <p style="color:var(--t3);font-size:13px;margin-top:10px;">No partner contacts recorded.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
