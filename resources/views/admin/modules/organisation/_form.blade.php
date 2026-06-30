@php
    /** @var \App\Models\Organisation $organisation */
    $addr = $organisation->address;

    $pocRows = old('pocs');
    if ($pocRows === null) {
        $pocRows = $organisation->pocs && $organisation->pocs->count()
            ? $organisation->pocs->map(fn ($p) => [
                'name'        => $p->name,
                'designation' => $p->designation,
                'mobile'      => $p->mobile,
                'email'       => $p->email,
            ])->toArray()
            : [];
    }
    if (empty($pocRows)) {
        $pocRows = [['name' => '', 'designation' => '', 'mobile' => '', 'email' => '']];
    }

    $loginTemplates = $loginTemplates ?? collect();
    $dashboardTemplates = $dashboardTemplates ?? collect();

    $val = fn ($field, $default = null) => old($field, $organisation->{$field} ?? $default);
    $addrVal = fn ($field, $default = null) => old($field, $addr->{$field} ?? $default);
@endphp

@if ($errors->any())
    <div class="alert alert-error">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <div>Please fix the {{ $errors->count() }} error(s) below before saving.</div>
    </div>
@endif

<div class="tabs" id="org-tabs">
    <div class="tab active" data-tab="t-details">Details</div>
    <div class="tab" data-tab="t-templates">Templates &amp; Contract</div>
    <div class="tab" data-tab="t-branding">Branding</div>
    <div class="tab" data-tab="t-address">Address</div>
    <div class="tab" data-tab="t-contacts">Contacts</div>
</div>

{{-- DETAILS --}}
<div class="tbc active" id="t-details">
    <div class="cd"><div class="cb">
        <div class="fgrid">
            <div class="fg">
                <label>Organisation Name <span style="color:var(--ros);">*</span></label>
                <input type="text" name="name" id="org-name" class="fi noi" value="{{ $val('name') }}" minlength="5" maxlength="180" placeholder="e.g. Sunrise Academy Group">
                @error('name')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Slug <span style="font-size:11px;color:var(--t3);">(auto-generated)</span></label>
                <input type="text" name="slug" id="org-slug" class="fi noi" value="{{ $val('slug') }}" readonly placeholder="sunrise-academy-group">
                @error('slug')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Email <span style="color:var(--ros);">*</span></label>
                <input type="email" name="email" class="fi noi" value="{{ $val('email') }}" minlength="4" maxlength="70" placeholder="admin@org.com">
                @error('email')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Mobile <span style="color:var(--ros);">*</span></label>
                <input type="text" name="mobile" class="fi noi" value="{{ $val('mobile') }}" inputmode="numeric" maxlength="10" placeholder="10-digit number">
                @error('mobile')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Password {{ $organisation->exists ? '(leave blank to keep)' : '' }} @unless($organisation->exists)<span style="color:var(--ros);">*</span>@endunless</label>
                <input type="password" name="password" class="fi noi" minlength="3" maxlength="20" placeholder="••••••••" autocomplete="new-password">
                @error('password')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Confirm Password @unless($organisation->exists)<span style="color:var(--ros);">*</span>@endunless</label>
                <input type="password" name="password_confirmation" class="fi noi" minlength="3" maxlength="20" placeholder="••••••••" autocomplete="new-password">
            </div>
            <div class="fg">
                <label>Sub-domain <span style="font-size:11px;color:var(--t3);">(optional)</span></label>
                <input type="text" name="sub_domain" class="fi noi" value="{{ $val('sub_domain') }}" minlength="3" maxlength="70" placeholder="sunrise">
                @error('sub_domain')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Custom Domain <span style="font-size:11px;color:var(--t3);">(optional)</span></label>
                <input type="text" name="domain" class="fi noi" value="{{ $val('domain') }}" minlength="3" maxlength="100" placeholder="app.org.edu.in">
                @error('domain')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
        </div>
    </div></div>
</div>

{{-- TEMPLATES & CONTRACT --}}
<div class="tbc" id="t-templates">
    <div class="cd"><div class="cb">
        <div class="fgrid">
            <div class="fg">
                <label>Login Template <span style="color:var(--ros);">*</span></label>
                <select name="login_template_id" class="fs">
                    <option value="">Select login template…</option>
                    @foreach ($loginTemplates as $tpl)
                        <option value="{{ $tpl->id }}" @selected((string) $val('login_template_id') === (string) $tpl->id)>{{ $tpl->name }}</option>
                    @endforeach
                </select>
                @error('login_template_id')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Dashboard Template <span style="color:var(--ros);">*</span></label>
                <select name="dashboard_template_id" class="fs">
                    <option value="">Select dashboard template…</option>
                    @foreach ($dashboardTemplates as $tpl)
                        <option value="{{ $tpl->id }}" @selected((string) $val('dashboard_template_id') === (string) $tpl->id)>{{ $tpl->name }}</option>
                    @endforeach
                </select>
                @error('dashboard_template_id')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>PO Date</label>
                <input type="date" name="po_date" class="fi noi" value="{{ old('po_date', optional($organisation->po_date)->format('Y-m-d')) }}">
                @error('po_date')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>PO Effective Date</label>
                <input type="date" name="po_effective_date" class="fi noi" value="{{ old('po_effective_date', optional($organisation->po_effective_date)->format('Y-m-d')) }}">
                @error('po_effective_date')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Contract Period (months)</label>
                <input type="number" name="contract_period" class="fi noi" value="{{ $val('contract_period') }}" min="1" max="100" step="1" placeholder="e.g. 12">
                @error('contract_period')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>MOU Document <span style="font-size:11px;color:var(--t3);">(pdf, doc, docx)</span></label>
                <input type="file" name="mou_document" class="fi noi" accept=".pdf,.doc,.docx">
                @if ($organisation->mou_document)<div style="font-size:11px;color:var(--t3);margin-top:4px;">Current: {{ basename($organisation->mou_document) }}</div>@endif
                @error('mou_document')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
        </div>
    </div></div>
</div>

{{-- BRANDING --}}
<div class="tbc" id="t-branding">
    <div class="cd"><div class="cb">
        <div class="fgrid">
            <div class="fg">
                <label>Logo @unless($organisation->exists)<span style="color:var(--ros);">*</span>@endunless</label>
                <input type="file" name="logo" class="fi noi" accept="image/*">
                @if ($organisation->logo)<div style="font-size:11px;color:var(--t3);margin-top:4px;">Current: {{ basename($organisation->logo) }}</div>@endif
                @error('logo')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Favicon @unless($organisation->exists)<span style="color:var(--ros);">*</span>@endunless</label>
                <input type="file" name="fav_icon" class="fi noi" accept="image/*">
                @if ($organisation->fav_icon)<div style="font-size:11px;color:var(--t3);margin-top:4px;">Current: {{ basename($organisation->fav_icon) }}</div>@endif
                @error('fav_icon')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display:flex;flex-wrap:wrap;gap:24px;margin-top:18px;padding-top:18px;border-top:1px solid var(--bdr);">
            <x-form.toggle name="is_2fa_enabled" label="2FA Enabled" :checked="$organisation->is_2fa_enabled ?? false" />
            <x-form.toggle name="is_active" label="Active" :checked="$organisation->is_active ?? true" />
        </div>
    </div></div>
</div>

{{-- ADDRESS --}}
<div class="tbc" id="t-address">
    <div class="cd"><div class="cb">
        <div class="fgrid">
            <div class="fg full">
                <label>Registered Address</label>
                <textarea name="address" class="fi noi" rows="2" placeholder="Full address">{{ $addrVal('address') }}</textarea>
            </div>
            <div class="fg"><label>Country</label><input type="text" name="country" class="fi noi" value="{{ $addrVal('country') }}" placeholder="India"></div>
            <div class="fg"><label>State</label><input type="text" name="state" class="fi noi" value="{{ $addrVal('state') }}"></div>
            <div class="fg"><label>District</label><input type="text" name="district" class="fi noi" value="{{ $addrVal('district') }}"></div>
            <div class="fg"><label>City</label><input type="text" name="city" class="fi noi" value="{{ $addrVal('city') }}"></div>
            <div class="fg"><label>Taluk</label><input type="text" name="taluk" class="fi noi" value="{{ $addrVal('taluk') }}"></div>
            <div class="fg"><label>Post Office</label><input type="text" name="post_office" class="fi noi" value="{{ $addrVal('post_office') }}"></div>
            <div class="fg"><label>Pincode</label><input type="text" name="pincode" class="fi noi" value="{{ $addrVal('pincode') }}"></div>
            <div class="fg"><label>Landline</label><input type="text" name="landline" class="fi noi" value="{{ $addrVal('landline') }}"></div>
            <div class="fg"><label>Geocode</label><input type="text" name="geocode" class="fi noi" value="{{ $addrVal('geocode') }}" placeholder="lat,lng"></div>
        </div>
    </div></div>
</div>

{{-- CONTACTS --}}
<div class="tbc" id="t-contacts">
    <div class="cd">
        <div class="ch">
            <span class="ctit">Points of Contact <span style="color:var(--ros);">*</span></span>
            <button type="button" class="btn bo bs" id="add-poc"><i class="fa-solid fa-plus"></i> Add Contact</button>
        </div>
        <div class="cb">
            <div id="poc-rows">
                @foreach ($pocRows as $i => $poc)
                    <div class="poc-row" style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr auto;gap:9px;align-items:start;margin-bottom:10px;">
                        <div class="fg" style="margin:0;">
                            <label>Name</label>
                            <input type="text" name="pocs[{{ $i }}][name]" class="fi noi" value="{{ $poc['name'] ?? '' }}" minlength="3" maxlength="50" placeholder="John Doe">
                            @error("pocs.$i.name")<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>
                        <div class="fg" style="margin:0;">
                            <label>Designation</label>
                            <input type="text" name="pocs[{{ $i }}][designation]" class="fi noi" value="{{ $poc['designation'] ?? '' }}" minlength="3" maxlength="50" placeholder="Director">
                            @error("pocs.$i.designation")<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>
                        <div class="fg" style="margin:0;">
                            <label>Mobile</label>
                            <input type="text" name="pocs[{{ $i }}][mobile]" class="fi noi" value="{{ $poc['mobile'] ?? '' }}" inputmode="numeric" maxlength="10" placeholder="10-digit">
                            @error("pocs.$i.mobile")<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>
                        <div class="fg" style="margin:0;">
                            <label>Email</label>
                            <input type="email" name="pocs[{{ $i }}][email]" class="fi noi" value="{{ $poc['email'] ?? '' }}" minlength="4" maxlength="50" placeholder="poc@org.com">
                            @error("pocs.$i.email")<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>
                        <button type="button" class="bi dng remove-poc" title="Remove" style="margin-top:22px;"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                @endforeach
            </div>
            <p style="font-size:11px;color:var(--t3);margin-top:6px;">At least one contact is required. All fields on each contact row are mandatory.</p>
        </div>
    </div>
</div>

{{-- WIZARD NAVIGATION --}}
<div style="display:flex;justify-content:space-between;gap:9px;margin-top:20px;">
    <a href="{{ route('admin.organisations.index') }}" class="btn bo">Cancel</a>
    <div style="display:flex;gap:9px;">
        <button type="button" class="btn bo" id="wiz-back" style="display:none;"><i class="fa-solid fa-arrow-left"></i> Back</button>
        <button type="button" class="btn ba" id="wiz-next">Next <i class="fa-solid fa-arrow-right"></i></button>
        <button type="submit" class="btn ba" id="wiz-submit" style="display:none;"><i class="fa-solid fa-save"></i> {{ $organisation->exists ? 'Update' : 'Create' }} Organisation</button>
    </div>
</div>

@push('scripts')
<script>
$(function () {
    // Auto-generate slug from organisation name.
    function slugify(v) {
        return v.toLowerCase().trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    }
    $('#org-name').on('input', function () {
        $('#org-slug').val(slugify($(this).val()));
    });

    // Restrict mobile inputs to digits.
    $(document).on('input', 'input[name="mobile"], input[name^="pocs"][name$="[mobile]"]', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });

    // ----- Tab wizard navigation -----
    var $tabs = $('#org-tabs .tab');
    var order = $tabs.map(function () { return $(this).data('tab'); }).get();

    function currentIndex() {
        var active = $('#org-tabs .tab.active').data('tab');
        var idx = order.indexOf(active);
        return idx < 0 ? 0 : idx;
    }

    function goTo(idx) {
        idx = Math.max(0, Math.min(order.length - 1, idx));
        var id = order[idx];
        $('#org-tabs .tab').removeClass('active');
        $('#org-tabs .tab[data-tab="' + id + '"]').addClass('active');
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
    // Error messages render as <div> with --ros colour; required-field asterisks
    // are <span>, so the div-only selector ignores them.
    var $errTbc = $('div.tbc').filter(function () { return $(this).find('div[style*="--ros"]').length > 0; }).first();
    if ($errTbc.length) {
        goTo(order.indexOf($errTbc.attr('id')));
    } else {
        syncButtons(0);
    }

    // ----- Repeatable POC rows -----
    var pocIndex = {{ count($pocRows) }};
    $('#add-poc').on('click', function () {
        var row =
            '<div class="poc-row" style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr auto;gap:9px;align-items:start;margin-bottom:10px;">' +
            '<div class="fg" style="margin:0;"><label>Name</label><input type="text" name="pocs[' + pocIndex + '][name]" class="fi noi" minlength="3" maxlength="50" placeholder="John Doe"></div>' +
            '<div class="fg" style="margin:0;"><label>Designation</label><input type="text" name="pocs[' + pocIndex + '][designation]" class="fi noi" minlength="3" maxlength="50" placeholder="Director"></div>' +
            '<div class="fg" style="margin:0;"><label>Mobile</label><input type="text" name="pocs[' + pocIndex + '][mobile]" class="fi noi" inputmode="numeric" maxlength="10" placeholder="10-digit"></div>' +
            '<div class="fg" style="margin:0;"><label>Email</label><input type="email" name="pocs[' + pocIndex + '][email]" class="fi noi" minlength="4" maxlength="50" placeholder="poc@org.com"></div>' +
            '<button type="button" class="bi dng remove-poc" title="Remove" style="margin-top:22px;"><i class="fa-solid fa-trash-can"></i></button>' +
            '</div>';
        $('#poc-rows').append(row);
        pocIndex++;
    });
    $(document).on('click', '.remove-poc', function () {
        if ($('#poc-rows .poc-row').length > 1) {
            $(this).closest('.poc-row').remove();
        } else {
            $(this).closest('.poc-row').find('input').val('');
        }
    });
});
</script>
@endpush
