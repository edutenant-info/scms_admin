@php
    /** @var \App\Models\Institution $institution */
    /** @var \Illuminate\Support\Collection $organisations */
    $meta = $institution->metadata ?? [];
    $addr = $institution->institutionAddress;

    $val = fn ($field, $default = null) => old($field, $institution->{$field} ?? $default);
    $addrVal = fn ($field, $default = null) => old($field, $addr->{$field} ?? $default);
    $metaVal = fn ($key, $default = '') => old($key, $meta[$key] ?? $default);
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
    <div class="tab" data-tab="t-settings">Settings</div>
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
                <input type="text" name="name" id="inst-name" class="fi noi" value="{{ $val('name') }}" placeholder="e.g. Sunrise Primary School">
                @error('name')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Display Name</label>
                <input type="text" name="display_name" class="fi noi" value="{{ $metaVal('display_name') }}" placeholder="Shown to end users">
            </div>
            <div class="fg">
                <label>Slug <span style="color:var(--ros);">*</span></label>
                <input type="text" name="slug" id="inst-slug" class="fi noi" value="{{ $val('slug') }}" placeholder="sunrise-primary">
                @error('slug')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="fg">
                <label>Type</label>
                <select name="type" class="fs">
                    @php $types = ['Primary School', 'High School', 'Junior College', 'K-12', 'Engineering College', 'Medical College', 'University', 'Polytechnic']; @endphp
                    <option value="">Select type…</option>
                    @foreach ($types as $t)
                        <option value="{{ $t }}" @selected($metaVal('type') === $t)>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="fg">
                <label>Board</label>
                <select name="board" class="fs">
                    @php $boards = ['CBSE', 'ICSE', 'State Board', 'IB', 'IGCSE', 'Cambridge', 'AICTE']; @endphp
                    <option value="">Select board…</option>
                    @foreach ($boards as $b)
                        <option value="{{ $b }}" @selected($metaVal('board') === $b)>{{ $b }}</option>
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
                <label>Address</label>
                <textarea name="address" class="fi noi" rows="2" placeholder="Full address">{{ $addrVal('address') }}</textarea>
            </div>
            <div class="fg"><label>Country</label><input type="text" name="country" class="fi noi" value="{{ $addrVal('country') }}" placeholder="India"></div>
            <div class="fg"><label>State</label><input type="text" name="state" class="fi noi" value="{{ $addrVal('state') }}"></div>
            <div class="fg"><label>District</label><input type="text" name="district" class="fi noi" value="{{ $addrVal('district') }}"></div>
            <div class="fg"><label>City</label><input type="text" name="city" class="fi noi" value="{{ $addrVal('city') }}"></div>
            <div class="fg"><label>Taluk</label><input type="text" name="taluk" class="fi noi" value="{{ $addrVal('taluk') }}"></div>
            <div class="fg"><label>Post Office</label><input type="text" name="post_office" class="fi noi" value="{{ $addrVal('post_office') }}"></div>
            <div class="fg"><label>Pincode</label><input type="text" name="pincode" class="fi noi" value="{{ $addrVal('pincode') }}"></div>
        </div>
    </div></div>
</div>

{{-- SETTINGS --}}
<div class="tbc" id="t-settings">
    <div class="cd"><div class="cb">
        <div class="fgrid">
            <div class="fg">
                <label>Database Name</label>
                <input type="text" name="database_name" class="fi noi" value="{{ $val('database_name') }}" placeholder="tenant_db_name">
            </div>
        </div>

        <div style="display:flex;flex-wrap:wrap;gap:24px;margin-top:18px;padding-top:18px;border-top:1px solid var(--bdr);">
            <label style="display:flex;align-items:center;gap:10px;font-size:13px;color:var(--t2);cursor:pointer;">
                <span class="sw"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $institution->is_active ?? true))><span class="sl"></span></span>
                Active
            </label>
        </div>
    </div></div>
</div>

<div style="display:flex;justify-content:flex-end;gap:9px;margin-top:20px;">
    <a href="{{ route('admin.institutions.index') }}" class="btn bo">Cancel</a>
    <button type="submit" class="btn ba"><i class="fa-solid fa-save"></i> {{ $institution->exists ? 'Update' : 'Create' }} Institution</button>
</div>

@push('scripts')
<script>
$(function () {
    // Auto-suggest slug from name while slug is untouched / empty.
    var slugTouched = $('#inst-slug').val().length > 0;
    $('#inst-slug').on('input', function () { slugTouched = true; });
    $('#inst-name').on('input', function () {
        if (slugTouched) return;
        var slug = $(this).val().toLowerCase().trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        $('#inst-slug').val(slug);
    });
});
</script>
@endpush
