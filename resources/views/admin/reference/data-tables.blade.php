@extends('admin.layouts.master', ['title' => 'Data Tables'])

@section('content')
@php
    // Sample dataset (mirrors the TailAdmin data-tables demo).
    $people = [
        ['name' => 'Abram Schleifer',   'email' => 'abram@example.com',   'position' => 'Sales Assistant',    'office' => 'Edinburgh', 'age' => 57, 'start' => '25 Apr, 2027', 'salary' => '$89,500', 'status' => 'Active',   'color' => 'linear-gradient(135deg,#6366F1,#818CF8)'],
        ['name' => 'Charlotte Anderson','email' => 'charlotte@example.com','position' => 'Support Engineer',   'office' => 'London',    'age' => 34, 'start' => '12 Mar, 2026', 'salary' => '$105,000','status' => 'Active',   'color' => 'linear-gradient(135deg,#22C55E,#4ADE80)'],
        ['name' => 'Ethan Robertson',   'email' => 'ethan@example.com',   'position' => 'Junior Developer',   'office' => 'New York',  'age' => 27, 'start' => '03 Jan, 2028', 'salary' => '$66,000', 'status' => 'Pending',  'color' => 'linear-gradient(135deg,#F97316,#FB923C)'],
        ['name' => 'Mia Williams',      'email' => 'mia@example.com',     'position' => 'Product Designer',   'office' => 'San Francisco','age' => 41,'start' => '19 Sep, 2025','salary' => '$120,000','status' => 'Active',   'color' => 'linear-gradient(135deg,#06B6D4,#22D3EE)'],
        ['name' => 'Noah Patel',        'email' => 'noah@example.com',    'position' => 'QA Analyst',         'office' => 'Singapore', 'age' => 30, 'start' => '08 Jul, 2026', 'salary' => '$72,400', 'status' => 'Cancelled','color' => 'linear-gradient(135deg,#F43F5E,#FB7185)'],
        ['name' => 'Olivia Martinez',   'email' => 'olivia@example.com',  'position' => 'HR Manager',         'office' => 'Berlin',    'age' => 45, 'start' => '30 Nov, 2024', 'salary' => '$98,000', 'status' => 'Active',   'color' => 'linear-gradient(135deg,#8B5CF6,#A78BFA)'],
        ['name' => 'Liam Chen',         'email' => 'liam@example.com',    'position' => 'DevOps Engineer',    'office' => 'Toronto',   'age' => 38, 'start' => '14 Feb, 2027', 'salary' => '$115,000','status' => 'Pending',  'color' => 'linear-gradient(135deg,#3B82F6,#60A5FA)'],
        ['name' => 'Sophia Rossi',      'email' => 'sophia@example.com',  'position' => 'Marketing Lead',     'office' => 'Milan',     'age' => 36, 'start' => '22 Jun, 2025', 'salary' => '$92,300', 'status' => 'Active',   'color' => 'linear-gradient(135deg,#EC4899,#F472B6)'],
        ['name' => 'James Walker',      'email' => 'james@example.com',   'position' => 'Sales Assistant',    'office' => 'Sydney',    'age' => 29, 'start' => '05 May, 2028', 'salary' => '$61,800', 'status' => 'Cancelled','color' => 'linear-gradient(135deg,#F59E0B,#FBBF24)'],
        ['name' => 'Emma Nguyen',       'email' => 'emma@example.com',    'position' => 'Data Scientist',     'office' => 'Tokyo',     'age' => 33, 'start' => '17 Oct, 2026', 'salary' => '$128,000','status' => 'Active',   'color' => 'linear-gradient(135deg,#14B8A6,#2DD4BF)'],
        ['name' => 'Benjamin Cole',     'email' => 'ben@example.com',     'position' => 'Support Engineer',   'office' => 'Dublin',    'age' => 42, 'start' => '11 Dec, 2027', 'salary' => '$78,900', 'status' => 'Pending',  'color' => 'linear-gradient(135deg,#6366F1,#818CF8)'],
        ['name' => 'Ava Thompson',      'email' => 'ava@example.com',     'position' => 'Product Manager',    'office' => 'London',    'age' => 39, 'start' => '02 Aug, 2025', 'salary' => '$134,500','status' => 'Active',   'color' => 'linear-gradient(135deg,#0EA5E9,#38BDF8)'],
    ];

    // Status → badge colour mapping used by Data Table 3.
    $statusBadges = [
        'Active'    => 'bg-act',
        'Pending'   => 'bg-pen',
        'Cancelled' => 'bg-ina',
    ];
@endphp

<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">UI Reference <i class="fa-solid fa-chevron-right"></i> Data Tables</div>
            <div class="pt">Data Tables</div>
            <div class="pst">Reusable client-side data table — search, sort, per-page &amp; pagination (TailAdmin Data Table 2 &amp; 3)</div>
        </div>
    </div>

    <div class="pg" style="grid-template-columns:1fr;gap:24px;">

        {{-- ── DATA TABLE 2 — search · sortable · pagination ───────────── --}}
        <div>
            <div style="font-size:13px;font-weight:600;margin-bottom:10px;color:var(--t1);">Data Table 2</div>
            <x-data-table
                :columns="[
                    ['key' => 'name',     'label' => 'User',       'sortable' => true, 'type' => 'user', 'sub' => 'email', 'color' => 'color'],
                    ['key' => 'position', 'label' => 'Position',   'sortable' => true, 'filter' => true],
                    ['key' => 'office',   'label' => 'Office',     'sortable' => true, 'filter' => true],
                    ['key' => 'age',      'label' => 'Age',        'sortable' => true],
                    ['key' => 'start',    'label' => 'Start date', 'sortable' => true],
                    ['key' => 'salary',   'label' => 'Salary',     'sortable' => true],
                    ['key' => 'action',   'label' => 'Action',     'type' => 'action', 'align' => 'right'],
                ]"
                :rows="$people"
                search-placeholder="Search..."
            />
            <p style="font-size:11px;color:var(--t3);margin-top:10px;">
                <code>&lt;x-data-table :columns="$columns" :rows="$rows" /&gt;</code>
                — flag a column with <code>'filter' =&gt; true</code> for a custom dropdown filter; the search box is an autocomplete type-ahead.
            </p>
        </div>

        {{-- ── DATA TABLE 3 — status badges · download (CSV export) ────── --}}
        <div>
            <div style="font-size:13px;font-weight:600;margin-bottom:10px;color:var(--t1);">Data Table 3</div>
            <x-data-table
                :columns="[
                    ['key' => 'name',     'label' => 'User',     'sortable' => true, 'type' => 'user', 'sub' => 'email', 'color' => 'color'],
                    ['key' => 'position', 'label' => 'Position', 'sortable' => true],
                    ['key' => 'salary',   'label' => 'Salary',   'sortable' => true],
                    ['key' => 'office',   'label' => 'Office',   'sortable' => true, 'filter' => true],
                    ['key' => 'status',   'label' => 'Status',   'sortable' => true, 'type' => 'badge', 'badges' => $statusBadges, 'filter' => true],
                    ['key' => 'action',   'label' => 'Action',   'type' => 'action', 'align' => 'right'],
                ]"
                :rows="$people"
                :downloadable="true"
                filename="employees"
                search-placeholder="Search..."
            />
            <p style="font-size:11px;color:var(--t3);margin-top:10px;">
                <code>&lt;x-data-table :columns="$columns" :rows="$rows" :downloadable="true" filename="employees" /&gt;</code>
                — adds a status badge column and a CSV <strong>Download</strong> button.
            </p>
        </div>

    </div>
</div>
@endsection
