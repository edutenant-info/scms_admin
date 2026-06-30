@php
    /** @var \App\Models\Institution $institution */
    /** @var \Illuminate\Support\Collection $organisations */
    /** @var \Illuminate\Support\Collection $institutionTypes */
    /** @var \Illuminate\Support\Collection $boards */
    /** @var \Illuminate\Support\Collection $dashboardTemplates */

    $partnerRows = old('partners');
    if ($partnerRows === null) {
        $partnerRows = $institution->partners && $institution->partners->count()
            ? $institution->partners->map(fn ($p) => [
                'name'        => $p->name,
                'designation' => $p->designation,
                'mobile'      => $p->mobile,
            ])->toArray()
            : [];
    }
    if (empty($partnerRows)) {
        $partnerRows = [['name' => '', 'designation' => '', 'mobile' => '']];
    }

    $val = fn ($field, $default = null) => old($field, $institution->{$field} ?? $default);
@endphp

@if ($errors->any())
    <div class="alert alert-error">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <div>Please fix the {{ $errors->count() }} error(s) below before saving.</div>
    </div>
@endif

<div class="tabs" id="inst-tabs">
    <div class="tab active" data-tab="t-details">Details</div>
    <div class="tab" data-tab="t-account">Account &amp; Domains</div>
    <div class="tab" data-tab="t-branding">Branding &amp; Template</div>
    <div class="tab" data-tab="t-partners">Partners</div>
</div>

{{-- DETAILS --}}
<div class="tbc active" id="t-details">
    <div class="cd"><div class="cb">
        <div class="fgrid">
            <div class="fg">
                <label>Organisation <span style="color:var(--ros);">*</span></label>
                <select name="organisation_id" class="fs">
                    <option value="">Select organisation…</option>
                    @foreach ($organisations as $id => $name)
                        <option value="{{ $id }}" @selected((int) old('organisation_id', $institution->organisation_id) === (int) $id)>{{ $name }}</option>
                    @endforeach
                </select>
                @error('organisation_id')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Institution Name <span style="color:var(--ros);">*</span></label>
                <input type="text" name="name" id="inst-name" class="fi noi" value="{{ $val('name') }}" minlength="5" maxlength="180" placeholder="e.g. Sunrise Primary School">
                @error('name')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Slug <span style="font-size:11px;color:var(--t3);">(auto-generated)</span></label>
                <input type="text" name="slug" id="inst-slug" class="fi noi" value="{{ $val('slug') }}" readonly placeholder="sunrise-primary-school">
                @error('slug')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Institution Type <span style="color:var(--ros);">*</span></label>
                <select name="institution_type_id" class="fs">
                    <option value="">Select type…</option>
                    @foreach ($institutionTypes as $id => $name)
                        <option value="{{ $id }}" @selected((int) old('institution_type_id', $institution->institution_type_id) === (int) $id)>{{ $name }}</option>
                    @endforeach
                </select>
                @error('institution_type_id')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Board <span style="color:var(--ros);">*</span></label>
                <select name="board_id" class="fs">
                    <option value="">Select board…</option>
                    @foreach ($boards as $id => $name)
                        <option value="{{ $id }}" @selected((int) old('board_id', $institution->board_id) === (int) $id)>{{ $name }}</option>
                    @endforeach
                </select>
                @error('board_id')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
        </div>
    </div></div>
</div>

{{-- ACCOUNT & DOMAINS --}}
<div class="tbc" id="t-account">
    <div class="cd"><div class="cb">
        <div class="fgrid">
            <div class="fg">
                <label>Email <span style="color:var(--ros);">*</span></label>
                <input type="email" name="email" class="fi noi" value="{{ $val('email') }}" minlength="4" maxlength="70" placeholder="admin@institution.com">
                @error('email')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Mobile <span style="color:var(--ros);">*</span></label>
                <input type="text" name="mobile" class="fi noi" value="{{ $val('mobile') }}" inputmode="numeric" maxlength="10" placeholder="10-digit number">
                @error('mobile')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Password {{ $institution->exists ? '(leave blank to keep)' : '' }} @unless($institution->exists)<span style="color:var(--ros);">*</span>@endunless</label>
                <input type="password" name="password" class="fi noi" minlength="3" maxlength="20" placeholder="••••••••" autocomplete="new-password">
                @error('password')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Confirm Password @unless($institution->exists)<span style="color:var(--ros);">*</span>@endunless</label>
                <input type="password" name="password_confirmation" class="fi noi" minlength="3" maxlength="20" placeholder="••••••••" autocomplete="new-password">
            </div>
            <div class="fg">
                <label>Sub-domain <span style="font-size:11px;color:var(--t3);">(optional)</span></label>
                <input type="text" name="sub_domain" class="fi noi" value="{{ $val('sub_domain') }}" minlength="3" maxlength="70" placeholder="sunrise">
                @error('sub_domain')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Domain <span style="font-size:11px;color:var(--t3);">(optional)</span></label>
                <input type="text" name="domain" class="fi noi" value="{{ $val('domain') }}" minlength="3" maxlength="10" placeholder="edu.in">
                @error('domain')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
        </div>
    </div></div>
</div>

{{-- BRANDING & TEMPLATE --}}
<div class="tbc" id="t-branding">
    <div class="cd"><div class="cb">
        <div class="fgrid">
            <div class="fg">
                <label>Logo @unless($institution->exists)<span style="color:var(--ros);">*</span>@endunless</label>
                <input type="file" name="logo" class="fi noi" accept="image/*">
                @if ($institution->logo)<div style="font-size:11px;color:var(--t3);margin-top:4px;">Current: {{ basename($institution->logo) }}</div>@endif
                @error('logo')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Favicon @unless($institution->exists)<span style="color:var(--ros);">*</span>@endunless</label>
                <input type="file" name="fav_icon" class="fi noi" accept="image/*">
                @if ($institution->fav_icon)<div style="font-size:11px;color:var(--t3);margin-top:4px;">Current: {{ basename($institution->fav_icon) }}</div>@endif
                @error('fav_icon')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Dashboard Template <span style="color:var(--ros);">*</span></label>
                <select name="dashboard_template_id" class="fs">
                    <option value="">Select dashboard template…</option>
                    @foreach ($dashboardTemplates as $id => $name)
                        <option value="{{ $id }}" @selected((int) old('dashboard_template_id', $institution->dashboard_template_id) === (int) $id)>{{ $name }}</option>
                    @endforeach
                </select>
                @error('dashboard_template_id')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Database Name <span style="font-size:11px;color:var(--t3);">(optional)</span></label>
                <input type="text" name="database_name" class="fi noi" value="{{ $val('database_name') }}" minlength="5" maxlength="20" placeholder="tenant_db_name">
                @error('database_name')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display:flex;flex-wrap:wrap;gap:24px;margin-top:18px;padding-top:18px;border-top:1px solid var(--bdr);">
            <x-form.toggle name="is_active" label="Active" :checked="$institution->is_active ?? true" />
        </div>
    </div></div>
</div>

{{-- PARTNERS (last tab) --}}
<div class="tbc" id="t-partners">
    <div class="cd"><div class="cb">
        <div class="fgrid">
            <div class="fg">
                <label>Zonal Partner Name <span style="color:var(--ros);">*</span></label>
                <input type="text" name="zonal_partner_name" class="fi noi" value="{{ $val('zonal_partner_name') }}" minlength="4" maxlength="50" placeholder="e.g. North Zone Partner">
                @error('zonal_partner_name')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
        </div>
    </div></div>

    <div class="cd" style="margin-top:14px;">
        <div class="ch">
            <span class="ctit">Partner Contacts <span style="color:var(--ros);">*</span></span>
            <button type="button" class="btn bo bs" id="add-partner"><i class="fa-solid fa-plus"></i> Add Partner</button>
        </div>
        <div class="cb">
            <div id="partner-rows">
                @foreach ($partnerRows as $i => $partner)
                    <div class="partner-row" style="display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:9px;align-items:start;margin-bottom:10px;">
                        <div class="fg" style="margin:0;">
                            <label>Name</label>
                            <input type="text" name="partners[{{ $i }}][name]" class="fi noi" value="{{ $partner['name'] ?? '' }}" minlength="3" maxlength="50" placeholder="John Doe">
                            @error("partners.$i.name")<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>
                        <div class="fg" style="margin:0;">
                            <label>Designation</label>
                            <input type="text" name="partners[{{ $i }}][designation]" class="fi noi" value="{{ $partner['designation'] ?? '' }}" minlength="3" maxlength="50" placeholder="Director">
                            @error("partners.$i.designation")<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>
                        <div class="fg" style="margin:0;">
                            <label>Mobile</label>
                            <input type="text" name="partners[{{ $i }}][mobile]" class="fi noi" value="{{ $partner['mobile'] ?? '' }}" inputmode="numeric" maxlength="10" placeholder="10-digit">
                            @error("partners.$i.mobile")<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>
                        <button type="button" class="bi dng remove-partner" title="Remove" style="margin-top:22px;"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                @endforeach
            </div>
            <p style="font-size:11px;color:var(--t3);margin-top:6px;">At least one partner contact is required. All fields on each row are mandatory.</p>
        </div>
    </div>
</div>

{{-- WIZARD NAVIGATION --}}
<div style="display:flex;justify-content:space-between;gap:9px;margin-top:20px;">
    <a href="{{ route('admin.institutions.index') }}" class="btn bo">Cancel</a>
    <div style="display:flex;gap:9px;">
        <button type="button" class="btn bo" id="wiz-back" style="display:none;"><i class="fa-solid fa-arrow-left"></i> Back</button>
        <button type="button" class="btn ba" id="wiz-next">Next <i class="fa-solid fa-arrow-right"></i></button>
        <button type="submit" class="btn ba" id="wiz-submit" style="display:none;"><i class="fa-solid fa-save"></i> {{ $institution->exists ? 'Update' : 'Create' }} Institution</button>
    </div>
</div>

@push('scripts')
<script>
$(function () {
    // Auto-generate slug from institution name.
    function slugify(v) {
        return v.toLowerCase().trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    }
    $('#inst-name').on('input', function () {
        $('#inst-slug').val(slugify($(this).val()));
    });

    // Restrict mobile inputs to digits.
    $(document).on('input', 'input[name="mobile"], input[name^="partners"][name$="[mobile]"]', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });

    // ----- Tab wizard navigation -----
    var $tabs = $('#inst-tabs .tab');
    var order = $tabs.map(function () { return $(this).data('tab'); }).get();

    function currentIndex() {
        var active = $('#inst-tabs .tab.active').data('tab');
        var idx = order.indexOf(active);
        return idx < 0 ? 0 : idx;
    }

    function goTo(idx) {
        idx = Math.max(0, Math.min(order.length - 1, idx));
        var id = order[idx];
        $('#inst-tabs .tab').removeClass('active');
        $('#inst-tabs .tab[data-tab="' + id + '"]').addClass('active');
        $('.tbc').removeClass('active');
        $('#' + id).addClass('active');
        syncButtons(idx);
    }

    function syncButtons(idx) {
        $('#wiz-back').toggle(idx > 0);
        var last = idx === order.length - 1;
        $('#wiz-next').toggle(!last);
        $('#wiz-submit').toggle(last);
    }

    $('#wiz-next').on('click', function () { goTo(currentIndex() + 1); });
    $('#wiz-back').on('click', function () { goTo(currentIndex() - 1); });

    // Keep wizard buttons in sync when a tab header is clicked directly.
    $tabs.on('click', function () { syncButtons(order.indexOf($(this).data('tab'))); });

    // If validation failed, jump to the first tab that contains an error message.
    var $errTbc = $('div.tbc').filter(function () { return $(this).find('div[style*="--ros"]').length > 0; }).first();
    if ($errTbc.length) {
        goTo(order.indexOf($errTbc.attr('id')));
    } else {
        syncButtons(0);
    }

    // ----- Repeatable partner rows -----
    var partnerIndex = {{ count($partnerRows) }};
    $('#add-partner').on('click', function () {
        var row =
            '<div class="partner-row" style="display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:9px;align-items:start;margin-bottom:10px;">' +
            '<div class="fg" style="margin:0;"><label>Name</label><input type="text" name="partners[' + partnerIndex + '][name]" class="fi noi" minlength="3" maxlength="50" placeholder="John Doe"></div>' +
            '<div class="fg" style="margin:0;"><label>Designation</label><input type="text" name="partners[' + partnerIndex + '][designation]" class="fi noi" minlength="3" maxlength="50" placeholder="Director"></div>' +
            '<div class="fg" style="margin:0;"><label>Mobile</label><input type="text" name="partners[' + partnerIndex + '][mobile]" class="fi noi" inputmode="numeric" maxlength="10" placeholder="10-digit"></div>' +
            '<button type="button" class="bi dng remove-partner" title="Remove" style="margin-top:22px;"><i class="fa-solid fa-trash-can"></i></button>' +
            '</div>';
        $('#partner-rows').append(row);
        partnerIndex++;
    });
    $(document).on('click', '.remove-partner', function () {
        if ($('#partner-rows .partner-row').length > 1) {
            $(this).closest('.partner-row').remove();
        } else {
            $(this).closest('.partner-row').find('input').val('');
        }
    });
});
</script>
@endpush
