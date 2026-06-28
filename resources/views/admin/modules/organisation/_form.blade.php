@php
    /** @var \App\Models\Organisation $organisation */
    $meta = $organisation->metadata ?? [];
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

    $val = fn ($field, $default = null) => old($field, $organisation->{$field} ?? $default);
    $addrVal = fn ($field, $default = null) => old($field, $addr->{$field} ?? $default);
@endphp

@if ($errors->any())
    <div class="alert alert-error">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <div>Please fix the {{ $errors->count() }} error(s) below before saving.</div>
    </div>
@endif

<div class="tabs">
    <div class="tab active" data-tab="t-details">Details</div>
    <div class="tab" data-tab="t-address">Address</div>
    <div class="tab" data-tab="t-contacts">Contacts</div>
    <div class="tab" data-tab="t-settings">Settings</div>
</div>

{{-- DETAILS --}}
<div class="tbc active" id="t-details">
    <div class="cd"><div class="cb">
        <div class="fgrid">
            <div class="fg">
                <label>Organisation Name <span style="color:var(--ros);">*</span></label>
                <input type="text" name="name" id="org-name" class="fi noi" value="{{ $val('name') }}" placeholder="e.g. Sunrise Academy Group">
                @error('name')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Slug / Subdomain <span style="color:var(--ros);">*</span></label>
                <input type="text" name="slug" id="org-slug" class="fi noi" value="{{ $val('slug') }}" placeholder="sunrise-academy">
                @error('slug')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Email <span style="color:var(--ros);">*</span></label>
                <input type="email" name="email" class="fi noi" value="{{ $val('email') }}" placeholder="admin@org.com">
                @error('email')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Mobile <span style="color:var(--ros);">*</span></label>
                <input type="text" name="mobile" class="fi noi" value="{{ $val('mobile') }}" placeholder="+91 98765 43210">
                @error('mobile')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Custom Domain</label>
                <input type="text" name="domain" class="fi noi" value="{{ $val('domain') }}" placeholder="app.org.edu.in">
                @error('domain')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Password {{ $organisation->exists ? '(leave blank to keep)' : '' }} @unless($organisation->exists)<span style="color:var(--ros);">*</span>@endunless</label>
                <input type="password" name="password" class="fi noi" placeholder="••••••••" autocomplete="new-password">
                @error('password')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Organisation Type</label>
                <select name="type" class="fs">
                    @php $types = ['K-12 School Group', 'Higher Education', 'Educational Trust', 'University', 'Coaching Institute']; @endphp
                    <option value="">Select type…</option>
                    @foreach ($types as $t)
                        <option value="{{ $t }}" @selected(old('type', $meta['type'] ?? '') === $t)>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="fg">
                <label>Subscription Plan</label>
                <select name="plan" class="fs">
                    @php $plans = ['Starter', 'Growth', 'Enterprise']; @endphp
                    <option value="">Select plan…</option>
                    @foreach ($plans as $p)
                        <option value="{{ $p }}" @selected(old('plan', $meta['plan'] ?? '') === $p)>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
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
            <span class="ctit">Points of Contact</span>
            <button type="button" class="btn bo bs" id="add-poc"><i class="fa-solid fa-plus"></i> Add Contact</button>
        </div>
        <div class="cb">
            <div id="poc-rows">
                @foreach ($pocRows as $i => $poc)
                    <div class="poc-row" style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr auto;gap:9px;align-items:end;margin-bottom:10px;">
                        <div class="fg" style="margin:0;"><label>Name</label><input type="text" name="pocs[{{ $i }}][name]" class="fi noi" value="{{ $poc['name'] ?? '' }}" placeholder="John Doe"></div>
                        <div class="fg" style="margin:0;"><label>Designation</label><input type="text" name="pocs[{{ $i }}][designation]" class="fi noi" value="{{ $poc['designation'] ?? '' }}" placeholder="Director"></div>
                        <div class="fg" style="margin:0;"><label>Mobile</label><input type="text" name="pocs[{{ $i }}][mobile]" class="fi noi" value="{{ $poc['mobile'] ?? '' }}" placeholder="+91…"></div>
                        <div class="fg" style="margin:0;"><label>Email</label><input type="email" name="pocs[{{ $i }}][email]" class="fi noi" value="{{ $poc['email'] ?? '' }}" placeholder="poc@org.com"></div>
                        <button type="button" class="bi dng remove-poc" title="Remove"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                @endforeach
            </div>
            <p style="font-size:11px;color:var(--t3);margin-top:6px;">Blank rows are ignored. A contact needs at least a name or mobile to be saved.</p>
        </div>
    </div>
</div>

{{-- SETTINGS --}}
<div class="tbc" id="t-settings">
    <div class="cd"><div class="cb">
        <div class="fgrid">
            <div class="fg">
                <label>Login Template</label>
                <input type="text" name="login_template" class="fi noi" value="{{ $val('login_template', 'login-1') }}">
            </div>
            <div class="fg">
                <label>Dashboard Template</label>
                <input type="text" name="dashboard_template" class="fi noi" value="{{ $val('dashboard_template', 'dashboard-1') }}">
            </div>
            <div class="fg">
                <label>PO Date</label>
                <input type="date" name="po_date" class="fi noi" value="{{ old('po_date', optional($organisation->po_date)->format('Y-m-d')) }}">
            </div>
            <div class="fg">
                <label>PO Effective Date</label>
                <input type="date" name="po_effective_date" class="fi noi" value="{{ old('po_effective_date', optional($organisation->po_effective_date)->format('Y-m-d')) }}">
            </div>
            <div class="fg">
                <label>Contract Period</label>
                <input type="text" name="contract_period" class="fi noi" value="{{ $val('contract_period') }}" placeholder="e.g. 12 months">
            </div>
            <div class="fg">
                <label>Email / SMS Mode</label>
                <input type="text" name="is_email_sms" class="fi noi" value="{{ $val('is_email_sms') }}" placeholder="e.g. both">
            </div>
            <div class="fg">
                <label>Vendor Type</label>
                <input type="text" name="vendor_type" class="fi noi" value="{{ $val('vendor_type') }}">
            </div>
            <div class="fg">
                <label>SMS Vendor</label>
                <input type="text" name="sms_vendor" class="fi noi" value="{{ $val('sms_vendor') }}">
            </div>
            <div class="fg">
                <label>Payment Gateway Vendor</label>
                <input type="text" name="payment_gateway_vendor" class="fi noi" value="{{ $val('payment_gateway_vendor') }}">
            </div>
            <div class="fg">
                <label>Logo</label>
                <input type="file" name="logo" class="fi noi" accept="image/*">
                @if ($organisation->logo)<div style="font-size:11px;color:var(--t3);margin-top:4px;">Current: {{ basename($organisation->logo) }}</div>@endif
                @error('logo')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>MOU Document</label>
                <input type="file" name="mou_document" class="fi noi" accept=".pdf,.doc,.docx">
                @if ($organisation->mou_document)<div style="font-size:11px;color:var(--t3);margin-top:4px;">Current: {{ basename($organisation->mou_document) }}</div>@endif
                @error('mou_document')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display:flex;flex-wrap:wrap;gap:24px;margin-top:18px;padding-top:18px;border-top:1px solid var(--bdr);">
            <label style="display:flex;align-items:center;gap:10px;font-size:13px;color:var(--t2);cursor:pointer;">
                <span class="sw"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $organisation->is_active ?? true))><span class="sl"></span></span>
                Active
            </label>
            <label style="display:flex;align-items:center;gap:10px;font-size:13px;color:var(--t2);cursor:pointer;">
                <span class="sw"><input type="checkbox" name="is_2fa_enabled" value="1" @checked(old('is_2fa_enabled', $organisation->is_2fa_enabled ?? false))><span class="sl"></span></span>
                2FA Enabled
            </label>
            <label style="display:flex;align-items:center;gap:10px;font-size:13px;color:var(--t2);cursor:pointer;">
                <span class="sw"><input type="checkbox" name="must_reset_password" value="1" @checked(old('must_reset_password', $organisation->must_reset_password ?? true))><span class="sl"></span></span>
                Must Reset Password
            </label>
        </div>
    </div></div>
</div>

<div style="display:flex;justify-content:flex-end;gap:9px;margin-top:20px;">
    <a href="{{ route('admin.organisations.index') }}" class="btn bo">Cancel</a>
    <button type="submit" class="btn ba"><i class="fa-solid fa-save"></i> {{ $organisation->exists ? 'Update' : 'Create' }} Organisation</button>
</div>

@push('scripts')
<script>
$(function () {
    // Auto-suggest slug from name (only while slug is untouched / empty).
    var slugTouched = $('#org-slug').val().length > 0;
    $('#org-slug').on('input', function () { slugTouched = true; });
    $('#org-name').on('input', function () {
        if (slugTouched) return;
        var slug = $(this).val().toLowerCase().trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        $('#org-slug').val(slug);
    });

    // Repeatable POC rows.
    var pocIndex = {{ count($pocRows) }};
    $('#add-poc').on('click', function () {
        var row =
            '<div class="poc-row" style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr auto;gap:9px;align-items:end;margin-bottom:10px;">' +
            '<div class="fg" style="margin:0;"><label>Name</label><input type="text" name="pocs[' + pocIndex + '][name]" class="fi noi" placeholder="John Doe"></div>' +
            '<div class="fg" style="margin:0;"><label>Designation</label><input type="text" name="pocs[' + pocIndex + '][designation]" class="fi noi" placeholder="Director"></div>' +
            '<div class="fg" style="margin:0;"><label>Mobile</label><input type="text" name="pocs[' + pocIndex + '][mobile]" class="fi noi" placeholder="+91…"></div>' +
            '<div class="fg" style="margin:0;"><label>Email</label><input type="email" name="pocs[' + pocIndex + '][email]" class="fi noi" placeholder="poc@org.com"></div>' +
            '<button type="button" class="bi dng remove-poc" title="Remove"><i class="fa-solid fa-trash-can"></i></button>' +
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
