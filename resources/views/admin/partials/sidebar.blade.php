<aside class="sb" id="sidebar">
    <div class="sb-head">
        <div class="sb-logo"><i class="fa-solid fa-graduation-cap"></i></div>
        <div class="sb-brand">{{ config('app.name') }}<span>Super Admin Console</span></div>
    </div>
    <nav class="sb-nav">
        <div class="ns">
            <div class="nst">Overview</div>
            <a href="{{ route('admin.dashboard') }}" class="ni active" data-view="dashboard"><i
                    class="fa-solid fa-gauge-high nic"></i> Dashboard</a>
        </div>
        <div class="ns">
            <div class="nst">Modules</div>
            <a href="{{ route('admin.organisations.index') }}"
               class="ni {{ request()->routeIs('admin.organisations.*') ? 'active' : '' }}">
                <i class="fa-solid fa-building nic"></i> Organisations
            </a>
            <a href="{{ route('admin.institutions.index') }}"
               class="ni {{ request()->routeIs('admin.institutions.*') ? 'active' : '' }}">
                <i class="fa-solid fa-school nic"></i> Institutions
            </a>
        </div>
        <div class="ns">
            <div class="nst">Settings</div>
            <a href="{{ route('admin.login-templates.index') }}"
               class="ni {{ request()->routeIs('admin.login-templates.*') ? 'active' : '' }}">
                <i class="fa-solid fa-right-to-bracket nic"></i> Login Templates
            </a>
            <a href="{{ route('admin.dashboard-templates.index') }}"
               class="ni {{ request()->routeIs('admin.dashboard-templates.*') ? 'active' : '' }}">
                <i class="fa-solid fa-table-columns nic"></i> Dashboard Templates
            </a>
        </div>
        <div class="ns">
            <div class="nst">System</div>
            <form method="POST" action="{{ route('admin.logout') }}" id="logout-form">
                @csrf
                <div class="ni" onclick="document.getElementById('logout-form').submit();"><i
                        class="fa-solid fa-right-from-bracket nic"></i> Logout</div>
            </form>
        </div>
    </nav>
    <div class="sb-ft">
        <div class="sb-user">
            <div class="sb-av">SA</div>
            <div class="sb-ui">
                <div class="sb-un">{{ Auth::guard('admin')->user()->name ?? 'Super Admin' }}</div>
                <div class="sb-ur">Platform Owner</div>
            </div>
        </div>
    </div>
</aside>
