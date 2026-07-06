@php
    /** @var \App\Models\InstitutionAcademicYear $item */
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
            <label>Institution <span style="color:var(--ros);">*</span></label>
            <select name="institution_id" class="fs">
                <option value="">Select institution…</option>
                @foreach ($institutions as $id => $name)
                    <option value="{{ $id }}" @selected((int) old('institution_id', $item->institution_id) === (int) $id)>{{ $name }}</option>
                @endforeach
            </select>
            @error('institution_id')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
        </div>
        <div class="fg">
            <label>Academic Year <span style="color:var(--ros);">*</span></label>
            <select name="academic_year_id" class="fs">
                <option value="">Select academic year…</option>
                @foreach ($academicYears as $id => $name)
                    <option value="{{ $id }}" @selected((int) old('academic_year_id', $item->academic_year_id) === (int) $id)>{{ $name }}</option>
                @endforeach
            </select>
            @error('academic_year_id')<div style="color:var(--ros);font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
        </div>
    </div>

    <div style="margin-top:18px;padding-top:18px;border-top:1px solid var(--bdr);">
        <x-form.toggle name="is_active" label="Active" :checked="$item->is_active ?? true" />
    </div>
</div></div>

<div style="display:flex;justify-content:flex-end;gap:9px;margin-top:20px;">
    <a href="{{ route('admin.institution-academic-years.index') }}" class="btn bo">Cancel</a>
    <button type="submit" class="btn ba"><i class="fa-solid fa-save"></i> {{ $item->exists ? 'Update' : 'Create' }} Mapping</button>
</div>
