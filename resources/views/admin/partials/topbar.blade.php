<div class="tb">
    <button class="tb-ham" id="hamburger"><i class="fa-solid fa-bars"></i></button>
    <div class="tb-src" id="search-trigger" role="button" tabindex="0" aria-label="Open search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Search…" readonly tabindex="-1">
        <span class="tb-src-kbd">⌘K</span>
    </div>
    <div class="tb-acts">
        {{-- @include('partials.theme-controls') --}}
<div class="nd-wrap">
            <div class="tb-btn" id="notif-trigger"><i class="fa-regular fa-bell"></i>
                <div class="nd"></div>
            </div>
            <div class="nd-menu" id="notif-menu">
                <div class="nd-head">
                    <span class="nd-title">Notifications</span>
                    <button class="nd-mar" id="notif-mark-all">Mark all read</button>
                </div>
                <div class="nd-list">
                    <div class="nit ur">
                        <div class="nic2" style="background:var(--accs);color:var(--acc);"><i class="fa-solid fa-school"></i></div>
                        <div class="ncnt">
                            <div class="ntt" style="color:var(--t1);">New organisation onboarded</div>
                            <div class="ndc">Sunrise Academy completed setup</div>
                            <div class="ntm">12 min ago</div>
                        </div>
                    </div>
                    <div class="nit ur">
                        <div class="nic2" style="background:var(--ambs);color:var(--amb);"><i class="fa-solid fa-triangle-exclamation"></i></div>
                        <div class="ncnt">
                            <div class="ntt" style="color:var(--t1);">Billing overdue</div>
                            <div class="ndc">St. Xavier's payment is 3 days late</div>
                            <div class="ntm">1 hr ago</div>
                        </div>
                    </div>
                    <div class="nit">
                        <div class="nic2" style="background:var(--grns);color:var(--grn);"><i class="fa-solid fa-puzzle-piece"></i></div>
                        <div class="ncnt">
                            <div class="ntt" style="color:var(--t1);">Module enabled</div>
                            <div class="ndc">DPS Bangalore activated Fee Mgmt</div>
                            <div class="ntm">3 hrs ago</div>
                        </div>
                    </div>
                    <div class="nit">
                        <div class="nic2" style="background:var(--cyns);color:var(--cyn);"><i class="fa-solid fa-link"></i></div>
                        <div class="ncnt">
                            <div class="ntt" style="color:var(--t1);">Academic year mapped</div>
                            <div class="ndc">Vidya Bharathi mapped AY 2025–26</div>
                            <div class="ntm">5 hrs ago</div>
                        </div>
                    </div>
                    <div class="nit">
                        <div class="nic2" style="background:var(--vios);color:var(--vio);"><i class="fa-solid fa-bell"></i></div>
                        <div class="ncnt">
                            <div class="ntt" style="color:var(--t1);">System broadcast sent</div>
                            <div class="ndc">Notification dispatched to all orgs</div>
                            <div class="ntm">Yesterday</div>
                        </div>
                    </div>
                </div>
                <div class="nd-foot">
                    <a href="#">View all notifications</a>
                </div>
            </div>
        </div>

        <!-- Profile Dropdown -->
        @php
            $pdName = Auth::guard('admin')->user()->name ?? 'Super Admin';
            $pdWords = preg_split('/\s+/', trim($pdName));
            $pdInitials = strtoupper(substr($pdWords[0] ?? 'A', 0, 1) . (count($pdWords) > 1 ? substr(end($pdWords), 0, 1) : ''));
        @endphp
        <div class="nd-wrap" x-data="{ open: false }" @click.away="open = false">
            <button @click="open = !open" class="pd-trigger" aria-label="Account menu">
                @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->profile_photo_url)
                    <img src="{{ Auth::guard('admin')->user()->profile_photo_url }}" alt="Profile">
                @else
                    {{ $pdInitials }}
                @endif
            </button>

            <div x-show="open" style="display: none;"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                 class="pd-menu">

                <!-- User Info -->
                <div class="pd-head">
                    <div class="pd-name">{{ Auth::guard('admin')->user()->name ?? 'Platform Admin' }}</div>
                    <div class="pd-email">{{ Auth::guard('admin')->user()->email ?? 'admin@scms.local' }}</div>
                </div>

                <div class="pd-sep"></div>

                <!-- Theme Toggle -->
                <div class="pd-theme-row" data-theme-controls x-data="{ currentMode: localStorage.getItem('theme-mode') || 'light' }">
                    <span class="pd-theme-label">Theme</span>
                    <div class="pd-theme">
                        <button type="button" data-theme-mode-option="light" @click="currentMode = 'light'" :class="{ 'active': currentMode === 'light' }" class="pd-theme-btn" aria-label="Light">
                            <i class="fa-regular fa-sun"></i>
                        </button>
                        <button type="button" data-theme-mode-option="dark" @click="currentMode = 'dark'" :class="{ 'active': currentMode === 'dark' }" class="pd-theme-btn" aria-label="Dark">
                            <i class="fa-regular fa-moon"></i>
                        </button>
                        <button type="button" data-theme-mode-option="system" @click="currentMode = 'system'" :class="{ 'active': currentMode === 'system' }" class="pd-theme-btn" aria-label="System">
                            <i class="fa-solid fa-desktop"></i>
                        </button>
                    </div>
                </div>

                <div class="pd-sep"></div>

                <!-- Links -->
                <a href="{{ Route::has('admin.profile') ? route('admin.profile') : '#' }}" class="pd-item">
                    <i class="fa-regular fa-user"></i> <span>Profile</span>
                </a>
                <a href="{{ Route::has('admin.settings') ? route('admin.settings') : '#' }}" class="pd-item">
                    <i class="fa-solid fa-gear"></i> <span>Settings</span>
                </a>
                <form method="POST" action="{{ Route::has('admin.logout') ? route('admin.logout') : '#' }}" class="m-0">
                    @csrf
                    <button type="submit" class="pd-item danger">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> <span>Log out</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
