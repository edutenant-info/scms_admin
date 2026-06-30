@php
    /** @var \App\Models\LoginTemplate $template */
    $val = fn ($field, $default = null) => old($field, $template->{$field} ?? $default);
@endphp

@if ($errors->any())
    <div class="alert alert-error">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <div>Please fix the {{ $errors->count() }} error(s) below before saving.</div>
    </div>
@endif

<div class="cd"><div class="cb">
    <div class="fgrid">
        <div class="fg">
            <label>Name <span style="color:var(--ros);">*</span></label>
            <input type="text" name="name" class="fi noi" value="{{ $val('name') }}" placeholder="e.g. Classic Login">
            @error('name')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
        </div>
        <div class="fg">
            <label>Code <span style="color:var(--ros);">*</span></label>
            <input type="text" name="code" class="fi noi" value="{{ $val('code') }}" placeholder="auto from name e.g. classic-login">
            @error('code')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
        </div>
        <div class="fg full">
            <label>Description</label>
            <input type="text" name="description" class="fi noi" value="{{ $val('description') }}" placeholder="Short description (optional)">
            @error('description')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
        </div>
    </div>

    <div style="margin-top:18px;padding-top:18px;border-top:1px solid var(--bdr);">
        <label style="display:flex;align-items:center;gap:10px;font-size:13px;color:var(--t2);cursor:pointer;">
            <span class="sw"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $template->is_active ?? true))><span class="sl"></span></span>
            Active
        </label>
    </div>
</div></div>

<div style="display:flex;justify-content:flex-end;gap:9px;margin-top:20px;">
    <a href="{{ route('admin.login-templates.index') }}" class="btn bo">Cancel</a>
    <button type="submit" class="btn ba"><i class="fa-solid fa-save"></i> {{ $template->exists ? 'Update' : 'Create' }} Template</button>
</div>
