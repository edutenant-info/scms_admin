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
            <a href="{{ route('admin.institution-types.index') }}"
               class="ni {{ request()->routeIs('admin.institution-types.*') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group nic"></i> Institution Types
            </a>
        </div>
        @php
            $academicActive = request()->routeIs(
                'admin.boards.*',
                'admin.subjects.*',
                'admin.streams.*',
                'admin.combinations.*',
                'admin.standards.*',
                'admin.semesters.*',
                'admin.sections.*',
                'admin.academic-years.*',
            );
            $demographicActive = request()->routeIs(
                'admin.castes.*',
                'admin.religions.*',
                'admin.blood-groups.*',
                'admin.nationalities.*',
                'admin.languages.*',
            );
            $feesActive = request()->routeIs(
                'admin.fee-types.*',
                'admin.master-categories.*',
                'admin.general-categories.*',
            );
        @endphp
        <div class="ns">
            <div class="nst">Master</div>
            <div class="ni hc {{ $academicActive ? 'active' : '' }}" data-toggle="ac-academic">
                <i class="fa-solid fa-book nic"></i> Academic
                <i class="fa-solid fa-chevron-right ntog {{ $academicActive ? 'open' : '' }}"></i>
            </div>
            <div class="nc {{ $academicActive ? 'open' : '' }}" id="ac-academic">
                <a href="{{ route('admin.boards.index') }}"
                   class="nch {{ request()->routeIs('admin.boards.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-clipboard-list nic"></i> Boards
                </a>
                <a href="{{ route('admin.subjects.index') }}"
                   class="nch {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-book-open nic"></i> Subjects
                </a>
                <a href="{{ route('admin.streams.index') }}"
                   class="nch {{ request()->routeIs('admin.streams.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-code-branch nic"></i> Streams
                </a>
                <a href="{{ route('admin.combinations.index') }}"
                   class="nch {{ request()->routeIs('admin.combinations.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-object-group nic"></i> Combinations
                </a>
                <a href="{{ route('admin.standards.index') }}"
                   class="nch {{ request()->routeIs('admin.standards.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-list-ol nic"></i> Standards
                </a>
                <a href="{{ route('admin.semesters.index') }}"
                   class="nch {{ request()->routeIs('admin.semesters.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-days nic"></i> Semesters
                </a>
                <a href="{{ route('admin.sections.index') }}"
                   class="nch {{ request()->routeIs('admin.sections.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-table-cells nic"></i> Sections
                </a>
                <a href="{{ route('admin.academic-years.index') }}"
                   class="nch {{ request()->routeIs('admin.academic-years.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar nic"></i> Academic Years
                </a>
            </div>
            <div class="ni hc {{ $demographicActive ? 'active' : '' }}" data-toggle="dm-demographic">
                <i class="fa-solid fa-users nic"></i> Demographic
                <i class="fa-solid fa-chevron-right ntog {{ $demographicActive ? 'open' : '' }}"></i>
            </div>
            <div class="nc {{ $demographicActive ? 'open' : '' }}" id="dm-demographic">
                <a href="{{ route('admin.castes.index') }}"
                   class="nch {{ request()->routeIs('admin.castes.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-people-group nic"></i> Caste
                </a>
                <a href="{{ route('admin.religions.index') }}"
                   class="nch {{ request()->routeIs('admin.religions.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-place-of-worship nic"></i> Religion
                </a>
                <a href="{{ route('admin.blood-groups.index') }}"
                   class="nch {{ request()->routeIs('admin.blood-groups.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-droplet nic"></i> Blood Group
                </a>
                <a href="{{ route('admin.nationalities.index') }}"
                   class="nch {{ request()->routeIs('admin.nationalities.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-flag nic"></i> Nationality
                </a>
                <a href="{{ route('admin.languages.index') }}"
                   class="nch {{ request()->routeIs('admin.languages.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-language nic"></i> Languages
                </a>
            </div>
            <div class="ni hc {{ $feesActive ? 'active' : '' }}" data-toggle="fee-fees">
                <i class="fa-solid fa-money-bill-wave nic"></i> Fees
                <i class="fa-solid fa-chevron-right ntog {{ $feesActive ? 'open' : '' }}"></i>
            </div>
            <div class="nc {{ $feesActive ? 'open' : '' }}" id="fee-fees">
                <a href="{{ route('admin.fee-types.index') }}"
                   class="nch {{ request()->routeIs('admin.fee-types.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-invoice-dollar nic"></i> Fee Type
                </a>
                <a href="{{ route('admin.master-categories.index') }}"
                   class="nch {{ request()->routeIs('admin.master-categories.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-sitemap nic"></i> Master Category
                </a>
                <a href="{{ route('admin.general-categories.index') }}"
                   class="nch {{ request()->routeIs('admin.general-categories.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-tags nic"></i> General Category
                </a>
            </div>
        </div>
        <div class="ns">
            <div class="nst">UI Reference</div>
            <a href="{{ route('admin.form-elements') }}"
               class="ni {{ request()->routeIs('admin.form-elements') ? 'active' : '' }}">
                <i class="fa-solid fa-wand-magic-sparkles nic"></i> Form Elements
            </a>
            <a href="{{ route('admin.data-tables') }}"
               class="ni {{ request()->routeIs('admin.data-tables') ? 'active' : '' }}">
                <i class="fa-solid fa-table-list nic"></i> Data Tables
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
