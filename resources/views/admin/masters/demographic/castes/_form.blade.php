@php
    /** @var \App\Models\Caste $item */
    $val = fn ($field, $default = null) => old($field, $item->{$field} ?? $default);
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
            <input type="text" name="name" class="fi noi" value="{{ $val('name') }}" minlength="1" maxlength="100" placeholder="e.g. General">
            @error('name')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
        </div>
        <div class="fg full">
            <label>Description</label>
            <input type="text" name="description" class="fi noi" value="{{ $val('description') }}" placeholder="Short description (optional)">
            @error('description')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
        </div>
    </div>

    <div style="margin-top:18px;padding-top:18px;border-top:1px solid var(--bdr);">
        <x-form.toggle name="is_active" label="Active" :checked="$item->is_active ?? true" />
    </div>
</div></div>

<div style="display:flex;justify-content:flex-end;gap:9px;margin-top:20px;">
    <a href="{{ route('admin.castes.index') }}" class="btn bo">Cancel</a>
    <button type="submit" class="btn ba"><i class="fa-solid fa-save"></i> {{ $item->exists ? 'Update' : 'Create' }} Caste</button>
</div>
