<!DOCTYPE html>
<html lang="en" data-theme-mode="light" data-theme-accent="blue">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'EduNexus — Multitenant School & College Management' }}</title>
    {{-- @include('partials.theme-init') --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,500&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
    window.ADMIN_ROUTES = {
        dashboard:        '{{ route("admin.dashboard") }}',
   
    };
    </script>
    @vite(['resources/css/app.css', 'resources/css/admin-custom.css', 'resources/js/app.js', 'resources/js/admin-custom.js'])
</head>

<body>
    {{-- Global page loader — shown during navigations & form submissions. --}}
    <div class="global-loader" id="global-loader" role="status" aria-live="polite" aria-hidden="true">
        <div class="gl-spinner"></div>
        <div class="gl-text">Loading…</div>
    </div>

    <div id="dashboard-page" style="display: block;">
        <div class="al">
            @include('admin.partials.sidebar')

            <div class="mw">
                @include('admin.partials.topbar')

                <div class="ct">
                    @if (session('status'))
                    <div class="alert alert-success">
                        <i class="fa-solid fa-check-circle"></i> {{ session('status') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-error">
                        <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
                    </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')
    @stack('scripts')

    <script>
    // Global Select2 initializer
    window.initSelect2 = function(container) {
        container = container || document;
        $(container).find('select.fs').each(function() {
            var $el = $(this);
            // Destroy existing instance before re-init (handles width refresh)
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.select2('destroy');
            }
            var isMultiple = $el.prop('multiple');
            var noSearch = $el.data('search') === false || $el.data('search') === 'false';
            $el.select2({
                width: '100%',
                // Hide the search box when data-search="false", else show it past 8 options.
                minimumResultsForSearch: noSearch ? Infinity : 8,
                placeholder: $el.data('placeholder') || $el.find('option[value=""]').text() || 'Select...',
                allowClear: !isMultiple && ($el.data('allow-clear') === true || $el.data('allow-clear') === 'true'),
                closeOnSelect: !isMultiple
            });
        });
    };

    // Global Flatpickr initializer
    window.initFlatpickr = function(container) {
        container = container || document;
        $(container).find('input[type="date"]').each(function() {
            if (this._flatpickr) return; // skip already initialized
            flatpickr(this, {
                dateFormat: 'Y-m-d',
                allowInput: true,
                disableMobile: true
            });
        });
    };

    // Init on page load (only visible content)
    $(function() {
        window.initSelect2();
        window.initFlatpickr();
    });
    </script>

    <!-- SEARCH MODAL -->
    <div class="sm-ov" id="search-modal" role="dialog" aria-modal="true" aria-label="Search">
        <div class="sm-box">
            <div class="sm-inp-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input class="sm-inp" id="sm-input" type="text" placeholder="Search organisations, institutions, menus, students…" autocomplete="off" spellcheck="false">
                <span class="sm-esc">ESC</span>
            </div>
            <div class="sm-cats">
                <button class="sm-cat active" data-cat="all">All</button>
                <button class="sm-cat" data-cat="organisation">Organisations</button>
                <button class="sm-cat" data-cat="institution">Institutions</button>
                <button class="sm-cat" data-cat="menu">Menus</button>
                <button class="sm-cat" data-cat="student">Students</button>
                <button class="sm-cat" data-cat="staff">Staff</button>
                <button class="sm-cat" data-cat="module">Modules</button>
            </div>
            <div class="sm-body" id="sm-body"></div>
            <div class="sm-kbds">
                <span class="sm-kbd-hint"><kbd>↑</kbd><kbd>↓</kbd> Navigate</span>
                <span class="sm-kbd-hint"><kbd>↵</kbd> Open</span>
                <span class="sm-kbd-hint"><kbd>ESC</kbd> Close</span>
                <span class="sm-kbd-hint" style="margin-left:auto;"><kbd>⌘</kbd><kbd>K</kbd> Search</span>
            </div>
        </div>
    </div>
</body>

</html>
