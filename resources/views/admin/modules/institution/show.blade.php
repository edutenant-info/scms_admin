@extends('admin.layouts.master', ['title' => $institution->name])

@section('content')
@php
    $meta = $institution->metadata ?? [];
    $addr = $institution->institutionAddress;
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
            @if (!empty($meta['type']))<span class="bp2 bp-ac">{{ $meta['type'] }}</span>@endif
            @if (!empty($meta['board']))<span class="bp2 bp-gr">{{ $meta['board'] }}</span>@endif
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
                    <tr><th>Display Name</th><td>{{ $meta['display_name'] ?? '—' }}</td></tr>
                    <tr><th>Slug</th><td>{{ $institution->slug }}</td></tr>
                    <tr><th>Type</th><td>{{ $meta['type'] ?? '—' }}</td></tr>
                    <tr><th>Board</th><td>{{ $meta['board'] ?? '—' }}</td></tr>
                    <tr><th>Database Name</th><td>{{ $institution->database_name ?? '—' }}</td></tr>
                    <tr><th>Status</th><td>{{ $institution->is_active ? 'Active' : 'Inactive' }}</td></tr>
                </table></div>
            </div>
        </div>

        {{-- Address --}}
        <div class="cd">
            <div class="ch"><span class="ctit">Address</span></div>
            <div class="cb">
                @if ($addr)
                    <div class="tw"><table>
                        <tr><th>Address</th><td>{{ $addr->address ?? '—' }}</td></tr>
                        <tr><th>City</th><td>{{ $addr->city ?? '—' }}</td></tr>
                        <tr><th>District</th><td>{{ $addr->district ?? '—' }}</td></tr>
                        <tr><th>State</th><td>{{ $addr->state ?? '—' }}</td></tr>
                        <tr><th>Country</th><td>{{ $addr->country ?? '—' }}</td></tr>
                        <tr><th>Pincode</th><td>{{ $addr->pincode ?? '—' }}</td></tr>
                        <tr><th>Post Office</th><td>{{ $addr->post_office ?? '—' }}</td></tr>
                    </table></div>
                @else
                    <p style="color:var(--t3);font-size:13px;">No address recorded.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
