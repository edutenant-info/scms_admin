@extends('admin.layouts.master', ['title' => 'Admin Dashboard'])

@section('content')
    <!-- DASHBOARD VIEW -->
    <div class="vs active" id="v-dashboard">
      <div class="ph">
        <div>
          <div class="pt">Dashboard</div>
          <div class="pst">Platform overview across all organisations</div>
        </div>
        <div style="display:flex;gap:7px;">
          <button class="btn bo"><i class="fa-solid fa-download"></i> Export</button>
          {{-- <a href="{{ route('admin.organisations.create') }}" class="btn ba"><i class="fa-solid fa-plus"></i> Onboard Organisation</a> --}}
        </div>
      </div>
      <div class="sg">
        <div class="sc"><div class="si"><i class="fa-solid fa-buildings"></i></div><div class="sv">{{ 0 }}</div><div class="sl">Total Organisations</div><span class="sch up"><i class="fa-solid fa-arrow-up"></i> 2 this qtr</span></div>
        <div class="sc"><div class="si"><i class="fa-solid fa-school"></i></div><div class="sv">47</div><div class="sl">Active Institutions</div><span class="sch up"><i class="fa-solid fa-arrow-up"></i> 5 this month</span></div>
        <div class="sc"><div class="si"><i class="fa-solid fa-user-graduate"></i></div><div class="sv">24.8K</div><div class="sl">Total Students</div><span class="sch up"><i class="fa-solid fa-arrow-up"></i> 12%</span></div>
        <div class="sc"><div class="si"><i class="fa-solid fa-puzzle-piece"></i></div><div class="sv">14</div><div class="sl">Active Modules</div><span class="sch up"><i class="fa-solid fa-arrow-up"></i> 3 new</span></div>
      </div>
      <div class="pg">
        <div class="cd"><div class="ch"><span class="ctit">Enrolment Trend</span><div style="display:flex;gap:5px;"><button class="btn bo bs">6M</button><button class="btn ba bs">12M</button></div></div><div class="cb"><div class="chc" id="echart"></div></div></div>
        <div class="cd"><div class="ch"><span class="ctit">Recent Activity</span></div><div class="cb" style="padding:8px 20px;">
          <div class="ai"><div class="ad" style="background:var(--grns);color:var(--grn);"><i class="fa-solid fa-check"></i></div><div><div class="at"><strong>Sunrise Academy</strong> completed onboarding</div><div class="atm">12 min ago</div></div></div>
          <div class="ai"><div class="ad" style="background:var(--accs);color:var(--acc);"><i class="fa-solid fa-puzzle-piece"></i></div><div><div class="at"><strong>DPS Bangalore</strong> — Fee Mgmt module enabled</div><div class="atm">1 hr ago</div></div></div>
          <div class="ai"><div class="ad" style="background:var(--ambs);color:var(--amb);"><i class="fa-solid fa-triangle-exclamation"></i></div><div><div class="at"><strong>St. Xavier's</strong> billing overdue</div><div class="atm">3 hrs ago</div></div></div>
          <div class="ai"><div class="ad" style="background:var(--cyns);color:var(--cyn);"><i class="fa-solid fa-link"></i></div><div><div class="at"><strong>Vidya Bharathi</strong> mapped AY 2025–26</div><div class="atm">5 hrs ago</div></div></div>
          <div class="ai"><div class="ad" style="background:var(--vios);color:var(--vio);"><i class="fa-solid fa-bell"></i></div><div><div class="at">System notification sent to <strong>all orgs</strong></div><div class="atm">Yesterday</div></div></div>
        </div></div>
      </div>
      <div class="cd">
        <div class="ch"><span class="ctit">Recent Organisations</span>
        {{-- <a href="{{ route('admin.organisations.index') }}" class="btn bo bs"><i class="fa-solid fa-filter"></i> Manage</a> --}}
      </div><div class="tw"><table><thead><tr><th>Organisation</th><th>Institutions</th><th>Students</th><th>Modules</th><th>Plan</th><th>Status</th><th>URL Pattern</th></tr></thead><tbody>
        @forelse ($organisations ?? [] as $organisation)
            <tr>
                <td><div class="to"><div class="toa" style="background:linear-gradient(135deg,var(--acc),var(--acc-2));color:var(--acc-contrast);">{{ substr($organisation->name ?? '', 0, 2) ?? 0 }}</div><div><div class="ton">{{ $organisation->name ?? ''}}</div><div style="font-size:10px;color:var(--t3);">{{ $organisation->slug ?? 0 }}.edunexus.io</div></div></div></td>
                <td>—</td>
                <td>—</td>
                <td>—</td>
                <td><span class="bp2 bp-ac">Enterprise</span></td>
                <td><span class="bdg bg-act">Active</span></td>
                <td style="font-family:monospace;font-size:10px;color:var(--cyn);">{inst}.{{ $organisation->slug ?? 0 }}.edunexus.io</td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center p-4">No organisations found.</td></tr>
        @endforelse
      </tbody></table></div></div>
    </div>
@endsection
