@extends('admin.layouts.master', ['title' => 'Form Elements'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">UI Reference <i class="fa-solid fa-chevron-right"></i> Form Elements</div>
            <div class="pt">Form Elements</div>
            <div class="pst">Reusable, themed form components — toggles, checkboxes, radios, file upload & select2</div>
        </div>
    </div>

    <div class="pg" style="grid-template-columns:1fr 1fr;align-items:start;">

        {{-- TOGGLE SWITCH --}}
        <div class="cd">
            <div class="ch"><span class="ctit">Toggle Switch</span></div>
            <div class="cb">
                <div style="display:flex;flex-direction:column;gap:16px;">
                    <x-form.toggle name="tgl_default" label="Default toggle" />
                    <x-form.toggle name="tgl_on" label="Checked by default" :checked="true" />
                    <x-form.toggle name="tgl_hint" label="Enable 2FA" hint="Require a second factor at sign-in" :checked="true" />
                    <x-form.toggle name="tgl_disabled" label="Disabled" :disabled="true" />
                    <x-form.toggle name="tgl_disabled_on" label="Disabled (on)" :checked="true" :disabled="true" />
                </div>
                <p style="font-size:11px;color:var(--t3);margin-top:16px;"><code>&lt;x-form.toggle name="is_active" label="Active" :checked="true" /&gt;</code></p>
            </div>
        </div>

        {{-- CHECKBOXES --}}
        <div class="cd">
            <div class="ch"><span class="ctit">Checkboxes</span></div>
            <div class="cb">
                <div style="display:flex;flex-direction:column;gap:14px;">
                    <x-form.checkbox name="chk_default" label="Default checkbox" />
                    <x-form.checkbox name="chk_checked" label="Checked by default" :checked="true" />
                    <x-form.checkbox name="chk_hint" label="Send email notifications" hint="We'll only email about account activity" :checked="true" />
                    <x-form.checkbox name="chk_disabled" label="Disabled" :disabled="true" />
                    <x-form.checkbox name="chk_disabled_on" label="Disabled (checked)" :checked="true" :disabled="true" />
                </div>
                <p style="font-size:11px;color:var(--t3);margin-top:16px;"><code>&lt;x-form.checkbox name="terms" label="I agree" /&gt;</code></p>
            </div>
        </div>

        {{-- RADIO BUTTONS --}}
        <div class="cd">
            <div class="ch"><span class="ctit">Radio Buttons</span></div>
            <div class="cb">
                <div style="display:flex;flex-direction:column;gap:14px;">
                    <x-form.radio name="plan" value="free" label="Free" :checked="true" />
                    <x-form.radio name="plan" value="pro" label="Pro" hint="Best for growing teams" />
                    <x-form.radio name="plan" value="enterprise" label="Enterprise" />
                    <x-form.radio name="plan" value="custom" label="Disabled option" :disabled="true" />
                </div>
                <p style="font-size:11px;color:var(--t3);margin-top:16px;"><code>&lt;x-form.radio name="plan" value="pro" label="Pro" /&gt;</code></p>
            </div>
        </div>

        {{-- SELECT2 DROPDOWNS --}}
        <div class="cd">
            <div class="ch"><span class="ctit">Select (Select2)</span></div>
            <div class="cb">
                <x-form.field label="Single select" :name="'country'">
                    <x-form.select name="country" placeholder="Choose a country…"
                        :options="['IN' => 'India', 'US' => 'United States', 'GB' => 'United Kingdom', 'CA' => 'Canada', 'AU' => 'Australia']"
                        selected="IN" />
                </x-form.field>

                <x-form.field label="Searchable + clearable">
                    <x-form.select name="board" placeholder="Select board…" :allow-clear="true"
                        :options="['CBSE' => 'CBSE', 'ICSE' => 'ICSE', 'State Board' => 'State Board', 'IB' => 'IB', 'IGCSE' => 'IGCSE', 'Cambridge' => 'Cambridge']" />
                </x-form.field>

                <x-form.field label="Multi-select" :name="'subjects'" hint="Pick one or more subjects">
                    <x-form.select name="subjects" :multiple="true" placeholder="Select subjects…"
                        :options="['math' => 'Mathematics', 'phy' => 'Physics', 'chem' => 'Chemistry', 'bio' => 'Biology', 'cs' => 'Computer Science', 'eng' => 'English']"
                        :selected="['math', 'phy']" />
                </x-form.field>

                <x-form.field label="No search box" style="margin-bottom:0;">
                    <x-form.select name="status" :search="false" placeholder="Select status…"
                        :options="['active' => 'Active', 'pending' => 'Pending', 'inactive' => 'Inactive']" selected="active" />
                </x-form.field>
            </div>
        </div>

        {{-- FILE UPLOAD --}}
        <div class="cd" style="grid-column:1/-1;">
            <div class="ch"><span class="ctit">File Upload (Drag &amp; Drop)</span></div>
            <div class="cb">
                <div class="fgrid">
                    <x-form.field label="Single file" :name="'mou_document'">
                        <x-form.file-upload name="mou_document" accept=".pdf,.doc,.docx" />
                    </x-form.field>

                    <x-form.field label="Multiple files (images)">
                        <x-form.file-upload name="gallery[]" :multiple="true" accept="image/*"
                            title="Drop images here" icon="fa-images" />
                    </x-form.field>
                </div>
                <p style="font-size:11px;color:var(--t3);margin-top:12px;"><code>&lt;x-form.file-upload name="logo" accept="image/*" :multiple="true" /&gt;</code> — drag a file in, or click to browse. Selected files list below the zone with per-file remove.</p>
            </div>
        </div>

    </div>
</div>
@endsection
