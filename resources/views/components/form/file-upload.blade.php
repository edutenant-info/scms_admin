@props([
    'name',
    'accept' => null,
    'multiple' => false,
    'title' => 'Drag & drop your file here',
    'browse' => 'or browse',
    'hint' => null,            // override the auto hint (accepted types)
    'icon' => 'fa-cloud-arrow-up',
    'current' => null,         // existing stored filename to surface (edit screens)
    'currentUrl' => null,      // optional link to the existing file
    'id' => null,
])

@php
    $fieldId = $id ?? 'fup-' . \Illuminate\Support\Str::slug($name, '-') . '-' . \Illuminate\Support\Str::random(4);
    $autoHint = $hint ?? ($accept ? 'Accepted: ' . str_replace(',', ', ', $accept) : null);
@endphp

<div class="fup" data-fup>
    <input
        type="file"
        id="{{ $fieldId }}"
        name="{{ $multiple ? $name . '[]' : $name }}"
        @if($accept) accept="{{ $accept }}" @endif
        @if($multiple) multiple @endif
        {{ $attributes }}
    >
    <div class="fup-ic"><i class="fa-solid {{ $icon }}"></i></div>
    <div class="fup-title">{{ $title }} <span>{{ $browse }}</span></div>
    @if($autoHint)<div class="fup-hint">{{ $autoHint }}</div>@endif

    @if($current)
        <div class="fup-current">
            Current:
            @if($currentUrl)<a href="{{ $currentUrl }}" target="_blank">{{ $current }}</a>@else{{ $current }}@endif
        </div>
    @endif

    <ul class="fup-files" data-fup-files></ul>
</div>
