@props([
    'name',
    'label' => null,
    'hint' => null,
    'value' => 1,
    'checked' => false,
    'disabled' => false,
    'id' => null,
])

@php
    // Honour old() input on validation redirects; fall back to the passed flag.
    $isChecked = old($name, $checked) ? true : false;
@endphp

<label {{ $attributes->class(['tgl', 'disabled' => $disabled]) }}>
    <input
        type="checkbox"
        name="{{ $name }}"
        value="{{ $value }}"
        @if($id) id="{{ $id }}" @endif
        @checked($isChecked)
        @disabled($disabled)
    >
    <span class="tgl-track"></span>
    @if($label)
        <span class="tgl-label">
            {{ $label }}
            @if($hint)<span class="tgl-hint">{{ $hint }}</span>@endif
        </span>
    @endif
</label>
