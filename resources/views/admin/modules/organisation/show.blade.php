@extends('admin.layouts.master', ['title' => $organisation->name])

@section('content')
@php
    $meta = $organisation->metadata ?? [];
    $addr = $organisation->address;
    $initials = strtoupper(mb_substr($organisation->name, 0, 2));
@endphp
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.organisations.index') }}">Organisations</a>
                <i class="fa-solid fa-chevron-right"></i> {{ $organisation->name }}
            </div>
            <div class="pt">{{ $organisation->name }}</div>
            <div class="pst">{{ $organisation->slug }}</div>
        </div>
        <div style="display:flex;gap:7px;">
            <a href="{{ route('admin.organisations.edit', $organisation) }}" class="btn ba"><i class="fa-solid fa-pen"></i> Edit</a>
            <form method="POST" action="{{ route('admin.organisations.destroy', $organisation) }}"
                  onsubmit="return confirm('Delete this organisation?');">
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
            <div style="font-size:20px;">{{ $organisation->name }}</div>
            <div style="font-size:12px;color:var(--t3);">{{ $organisation->email }} · {{ $organisation->mobile }}</div>
            @if ($organisation->domain)
                <div style="font-size:11px;color:var(--cyn);margin-top:2px;font-family:monospace;"><i class="fa-solid fa-link"></i> {{ $organisation->domain }}</div>
            @endif
        </div>
        <div style="display:flex;gap:7px;align-items:center;">
            @if ($organisation->is_active)
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
                    <tr><th>Slug</th><td>{{ $organisation->slug }}</td></tr>
                    <tr><th>Sub-domain</th><td>{{ $organisation->sub_domain ?? '—' }}</td></tr>
                    <tr><th>Domain</th><td>{{ $organisation->domain ?? '—' }}</td></tr>
                    <tr><th>Login Template</th><td>{{ $organisation->loginTemplate->name ?? '—' }}</td></tr>
                    <tr><th>Dashboard Template</th><td>{{ $organisation->dashboardTemplate->name ?? '—' }}</td></tr>
                    <tr><th>Contract Period</th><td>{{ $organisation->contract_period ? $organisation->contract_period . ' month(s)' : '—' }}</td></tr>
                    <tr><th>PO Date</th><td>{{ optional($organisation->po_date)->format('M d, Y') ?? '—' }}</td></tr>
                    <tr><th>PO Effective</th><td>{{ optional($organisation->po_effective_date)->format('M d, Y') ?? '—' }}</td></tr>
                    <tr><th>2FA</th><td>{{ $organisation->is_2fa_enabled ? 'Enabled' : 'Disabled' }}</td></tr>
                    <tr><th>Institutions</th><td>{{ $organisation->institutions->count() }}</td></tr>
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
                        <tr><th>Landline</th><td>{{ $addr->landline ?? '—' }}</td></tr>
                    </table></div>
                @else
                    <p style="color:var(--t3);font-size:13px;">No address recorded.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Points of contact --}}
    <div class="cd">
        <div class="ch"><span class="ctit">Points of Contact</span></div>
        <div class="tw"><table>
            <thead><tr><th>Name</th><th>Designation</th><th>Mobile</th><th>Email</th></tr></thead>
            <tbody>
                @forelse ($organisation->pocs as $poc)
                    <tr>
                        <td style="color:var(--t1);font-weight:500;">{{ $poc->name }}</td>
                        <td>{{ $poc->designation ?? '—' }}</td>
                        <td>{{ $poc->mobile }}</td>
                        <td>{{ $poc->email ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;padding:20px;color:var(--t3);">No contacts recorded.</td></tr>
                @endforelse
            </tbody>
        </table></div>
    </div>
</div>
@endsection
