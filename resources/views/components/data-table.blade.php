@props([
    'id'              => null,
    'title'           => null,          // optional card header title
    'columns'         => [],            // see normalisation below
    'rows'            => [],            // list of associative arrays keyed by column 'key'
    'searchable'      => true,          // show the search box in the toolbar
    'downloadable'    => false,         // show a "Download" (CSV export) button — Data Table 3
    'perPageOptions'  => [10, 8, 5],    // choices in the "Show … entries" selector
    'perPage'         => 10,            // default rows per page
    'searchPlaceholder' => 'Search…',
    'emptyText'       => 'No matching records found.',
    'filename'        => 'export',      // CSV file name (without extension)
])

@php
    // ── Normalise column definitions into a predictable shape ────────────────
    // Each column: [
    //   'key'      => data key,
    //   'label'    => header text,
    //   'sortable' => bool,
    //   'type'     => 'text' | 'user' | 'badge' | 'action',
    //   'sub'      => secondary data key (user subtitle),
    //   'avatar'   => data key holding initials (else derived from value),
    //   'color'    => data key holding an avatar background (css value),
    //   'badges'   => map of value => badge class (bg-act|bg-pen|bg-tri|bg-ina),
    //   'align'    => 'left' | 'right' | 'center',
    // ]
    $cols = collect($columns)->map(function ($c) {
        return [
            'key'      => $c['key'] ?? '',
            'label'    => $c['label'] ?? \Illuminate\Support\Str::headline($c['key'] ?? ''),
            'sortable' => (bool) ($c['sortable'] ?? false),
            'filter'   => (bool) ($c['filter'] ?? false),
            'type'     => $c['type'] ?? 'text',
            'sub'      => $c['sub'] ?? null,
            'avatar'   => $c['avatar'] ?? null,
            'color'    => $c['color'] ?? null,
            'badges'   => $c['badges'] ?? null,
            'align'    => $c['align'] ?? 'left',
        ];
    })->values()->all();

    $tableId = $id ?? 'dt-' . \Illuminate\Support\Str::random(6);

    $config = [
        'rows'     => array_values($rows),
        'columns'  => $cols,
        'perPage'  => (int) $perPage,
        'filename' => $filename,
    ];
@endphp

<div class="cd" x-data="dataTable(@js($config))" id="{{ $tableId }}">
    @if($title)
        <div class="ch"><span class="ctit">{{ $title }}</span></div>
    @endif

    {{-- ── Toolbar: per-page selector (left) · filters + search + download (right) ── --}}
    <div class="dt-tools">
        <label class="dt-len">
            <span>Show</span>
            <select class="dt-len-sel" x-model.number="perPage">
                @foreach($perPageOptions as $opt)
                    <option value="{{ $opt }}">{{ $opt }}</option>
                @endforeach
            </select>
            <span>entries</span>
        </label>

        <div class="dt-actions">
            {{-- Custom per-column filters (columns flagged with 'filter' => true) --}}
            <template x-for="col in filterCols" :key="col.key">
                <select class="dt-len-sel dt-filter-sel" x-model="filters[col.key]" @change="page = 1">
                    <option value="" x-text="'All ' + col.label"></option>
                    <template x-for="opt in filterOptions(col)" :key="opt">
                        <option :value="opt" x-text="opt"></option>
                    </template>
                </select>
            </template>
            <button type="button" class="btn bo bs dt-filter-clear"
                    x-show="hasActiveFilters" x-cloak @click="clearFilters()">
                <i class="fa-solid fa-filter-circle-xmark"></i> Clear
            </button>

            @if($searchable)
                {{-- Autocomplete search: type-ahead suggestions from the dataset --}}
                <div class="msrc dt-search" @click.outside="showSuggest = false">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" x-model="search" autocomplete="off"
                           placeholder="{{ $searchPlaceholder }}"
                           @focus="showSuggest = true"
                           @input="showSuggest = true; activeSuggest = -1"
                           @keydown.down.prevent="moveSuggest(1)"
                           @keydown.up.prevent="moveSuggest(-1)"
                           @keydown.enter.prevent="chooseSuggest()"
                           @keydown.escape="showSuggest = false">
                    <div class="dt-suggest" x-show="showSuggest && suggestions.length" x-cloak>
                        <template x-for="(s, i) in suggestions" :key="s">
                            <div class="dt-suggest-item"
                                 :class="i === activeSuggest ? 'active' : ''"
                                 @mousedown.prevent="applySuggest(s)"
                                 @mouseenter="activeSuggest = i">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span x-html="highlight(s)"></span>
                            </div>
                        </template>
                    </div>
                </div>
            @endif
            @if($downloadable)
                <button type="button" class="btn bo bs" @click="download()">
                    <i class="fa-solid fa-download"></i> Download
                </button>
            @endif
        </div>
    </div>

    {{-- ── Table ──────────────────────────────────────────────────────── --}}
    <div class="tw">
        <table>
            <thead>
                <tr>
                    <template x-for="col in columns" :key="col.key">
                        <th :style="{'text-align': col.align}">
                            <span class="dt-th"
                                  :class="col.sortable ? 'dt-sortable' : ''"
                                  @click="doSort(col)">
                                <span x-text="col.label"></span>
                                <template x-if="col.sortable">
                                    <span class="dt-sort">
                                        <i class="fa-solid fa-sort"      x-show="sortKey !== col.key"></i>
                                        <i class="fa-solid fa-sort-up"   x-show="sortKey === col.key && sortDir === 'asc'"></i>
                                        <i class="fa-solid fa-sort-down" x-show="sortKey === col.key && sortDir === 'desc'"></i>
                                    </span>
                                </template>
                            </span>
                        </th>
                    </template>
                </tr>
            </thead>
            <tbody>
                <template x-for="(row, idx) in paged" :key="idx">
                    <tr>
                        <template x-for="col in columns" :key="col.key">
                            <td :style="{'text-align': col.align}">
                                {{-- user cell: avatar + name + subtitle --}}
                                <template x-if="col.type === 'user'">
                                    <div class="to">
                                        <div class="toa"
                                             :style="'background:' + (col.color && row[col.color] ? row[col.color] : 'linear-gradient(135deg,var(--acc),#818CF8)')"
                                             x-text="initials(row, col)"></div>
                                        <div>
                                            <div class="ton" x-text="row[col.key]"></div>
                                            <template x-if="col.sub">
                                                <div style="font-size:10px;color:var(--t3);" x-text="row[col.sub]"></div>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                {{-- badge / status cell --}}
                                <template x-if="col.type === 'badge'">
                                    <span class="bdg" :class="badgeClass(row, col)" x-text="row[col.key]"></span>
                                </template>

                                {{-- action cell: view · edit · delete icons --}}
                                <template x-if="col.type === 'action'">
                                    <div class="ta">
                                        <button type="button" class="bi" title="View"><i class="fa-solid fa-eye"></i></button>
                                        <button type="button" class="bi" title="Edit"><i class="fa-solid fa-pen"></i></button>
                                        <button type="button" class="bi dng" title="Delete"><i class="fa-solid fa-trash-can"></i></button>
                                    </div>
                                </template>

                                {{-- plain text cell (default) --}}
                                <template x-if="!['user','badge','action'].includes(col.type)">
                                    <span x-text="row[col.key]"></span>
                                </template>
                            </td>
                        </template>
                    </tr>
                </template>

                {{-- empty state --}}
                <template x-if="total === 0">
                    <tr>
                        <td :colspan="columns.length" style="text-align:center;padding:32px;color:var(--t3);">
                            {{ $emptyText }}
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    {{-- ── Footer: entry counter (left) · pagination (right) ──────────── --}}
    <div class="dt-foot">
        <div class="dt-count">
            Showing <span x-text="from"></span> to <span x-text="to"></span> of <span x-text="total"></span> entries
        </div>
        <div class="dt-pag">
            <button type="button" class="dt-pg" :disabled="page === 1" @click="goto(page - 1)">Previous</button>
            <template x-for="p in pageNumbers" :key="p">
                <button type="button" class="dt-pg" :class="p === page ? 'active' : ''" @click="goto(p)" x-text="p"></button>
            </template>
            <button type="button" class="dt-pg" :disabled="page === pageCount" @click="goto(page + 1)">Next</button>
        </div>
    </div>
</div>

@once
    @push('scripts')
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dataTable', (config) => ({
            rows:    config.rows || [],
            columns: config.columns || [],
            filename: config.filename || 'export',
            search:  '',
            sortKey: '',
            sortDir: 'asc',
            perPage: config.perPage || 10,
            page:    1,
            filters: {},        // { columnKey: selectedValue } for custom filters
            showSuggest: false, // autocomplete dropdown visibility
            activeSuggest: -1,  // keyboard-highlighted suggestion index

            init() {
                // Seed a blank filter slot for every filterable column.
                this.columns.forEach(c => { if (c.filter) this.filters[c.key] = ''; });
                // Any change that shrinks/rearranges the result set returns to page 1.
                this.$watch('search',  () => this.page = 1);
                this.$watch('perPage', () => this.page = 1);
            },

            // ── Custom filters ──────────────────────────────────────────
            get filterCols() { return this.columns.filter(c => c.filter); },
            get hasActiveFilters() {
                return this.filterCols.some(c => this.filters[c.key]);
            },
            // Distinct, sorted values for a column's filter dropdown.
            filterOptions(col) {
                const set = new Set();
                this.rows.forEach(r => {
                    const v = r[col.key];
                    if (v !== undefined && v !== null && v !== '') set.add(String(v));
                });
                return [...set].sort((a, b) => a.localeCompare(b));
            },
            clearFilters() {
                this.filterCols.forEach(c => this.filters[c.key] = '');
                this.page = 1;
            },

            // ── Derived data ────────────────────────────────────────────
            get filtered() {
                let rows = this.rows;
                // Exact-match custom column filters.
                const active = this.filterCols.filter(c => this.filters[c.key]);
                if (active.length) {
                    rows = rows.filter(r => active.every(c => String(r[c.key] ?? '') === this.filters[c.key]));
                }
                // Free-text search across all columns (+ user subtitles).
                const q = this.search.trim().toLowerCase();
                if (q) {
                    rows = rows.filter(r => this.columns.some(c => {
                        let v = String(r[c.key] ?? '');
                        if (c.sub) v += ' ' + String(r[c.sub] ?? '');
                        return v.toLowerCase().includes(q);
                    }));
                }
                return rows;
            },

            // ── Autocomplete suggestions ────────────────────────────────
            get suggestions() {
                const q = this.search.trim().toLowerCase();
                if (!q) return [];
                const seen = new Set(), out = [];
                for (const r of this.rows) {
                    for (const c of this.columns) {
                        if (c.type === 'action') continue;
                        const val = String(r[c.key] ?? '');
                        const key = val.toLowerCase();
                        if (val && key.includes(q) && !seen.has(key)) {
                            seen.add(key);
                            out.push(val);
                            if (out.length >= 8) return out;
                        }
                    }
                }
                return out;
            },
            moveSuggest(dir) {
                const n = this.suggestions.length;
                if (!n) return;
                this.showSuggest = true;
                this.activeSuggest = (this.activeSuggest + dir + n) % n;
            },
            chooseSuggest() {
                const s = this.suggestions[this.activeSuggest];
                if (s !== undefined) this.applySuggest(s);
                else this.showSuggest = false;
            },
            applySuggest(v) {
                this.search = v;
                this.showSuggest = false;
                this.activeSuggest = -1;
            },
            escapeHtml(s) {
                return String(s).replace(/[&<>"']/g, c =>
                    ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
            },
            highlight(s) {
                const esc = this.escapeHtml(s);
                const q = this.search.trim();
                if (!q) return esc;
                const eq = this.escapeHtml(q).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                return esc.replace(new RegExp('(' + eq + ')', 'ig'), '<strong>$1</strong>');
            },
            get sorted() {
                if (!this.sortKey) return this.filtered;
                const dir = this.sortDir === 'asc' ? 1 : -1;
                return [...this.filtered].sort((a, b) => {
                    let x = a[this.sortKey], y = b[this.sortKey];
                    // Numeric-aware compare (handles "$120,000", "44", etc.)
                    const nx = parseFloat(String(x).replace(/[^0-9.\-]/g, ''));
                    const ny = parseFloat(String(y).replace(/[^0-9.\-]/g, ''));
                    if (!isNaN(nx) && !isNaN(ny)) { x = nx; y = ny; }
                    else { x = String(x).toLowerCase(); y = String(y).toLowerCase(); }
                    return x < y ? -dir : x > y ? dir : 0;
                });
            },
            get total()     { return this.sorted.length; },
            get pageCount() { return Math.max(1, Math.ceil(this.total / this.perPage)); },
            get paged() {
                const start = (this.page - 1) * this.perPage;
                return this.sorted.slice(start, start + this.perPage);
            },
            get from() { return this.total === 0 ? 0 : (this.page - 1) * this.perPage + 1; },
            get to()   { return Math.min(this.page * this.perPage, this.total); },
            get pageNumbers() {
                const c = this.pageCount, p = this.page;
                let start = Math.max(1, p - 2);
                let end   = Math.min(c, start + 4);
                start = Math.max(1, end - 4);
                const out = [];
                for (let i = start; i <= end; i++) out.push(i);
                return out;
            },

            // ── Actions ─────────────────────────────────────────────────
            doSort(col) {
                if (!col.sortable) return;
                if (this.sortKey === col.key) {
                    this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
                } else {
                    this.sortKey = col.key;
                    this.sortDir = 'asc';
                }
                this.page = 1;
            },
            goto(p) { if (p >= 1 && p <= this.pageCount) this.page = p; },

            // ── Cell helpers ────────────────────────────────────────────
            initials(row, col) {
                if (col.avatar && row[col.avatar]) return row[col.avatar];
                return String(row[col.key] || '')
                    .split(' ').filter(Boolean).map(w => w[0]).slice(0, 2).join('').toUpperCase();
            },
            badgeClass(row, col) {
                const v = row[col.key];
                if (col.badges && col.badges[v]) return col.badges[v];
                return 'bg-act';
            },

            // ── CSV export (Data Table 3) ───────────────────────────────
            download() {
                const cols = this.columns.filter(c => c.type !== 'action');
                const esc  = (v) => '"' + String(v ?? '').replace(/"/g, '""') + '"';
                const lines = [cols.map(c => esc(c.label)).join(',')];
                this.sorted.forEach(r => {
                    lines.push(cols.map(c => {
                        let v = r[c.key] ?? '';
                        if (c.sub && r[c.sub]) v = v + ' (' + r[c.sub] + ')';
                        return esc(v);
                    }).join(','));
                });
                const blob = new Blob([lines.join('\n')], { type: 'text/csv;charset=utf-8;' });
                const url  = URL.createObjectURL(blob);
                const a    = document.createElement('a');
                a.href = url;
                a.download = this.filename + '.csv';
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(url);
            },
        }));
    });
    </script>
    @endpush
@endonce
