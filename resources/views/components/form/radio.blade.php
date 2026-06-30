@props([
    'name',
    'value',
    'label' => null,
    'hint' => null,
    'checked' => false,
    'disabled' => false,
    'id' => null,
])

@php
    // For radios, old() holds the chosen value; match it against this option.
    $old = old($name);
    $isChecked = $old !== null ? ((string) $old === (string) $value) : (bool) $checked;
@endphp

<label {{ $attributes->class(['rdo', 'disabled' => $disabled]) }}>
    <input
        type="radio"
        name="{{ $name }}"
        value="{{ $value }}"
        @if($id) id="{{ $id }}" @endif
        @checked($isChecked)
        @disabled($disabled)
    >
    @if($label)
        <span>{{ $label }}@if($hint)<span class="rdo-hint">{{ $hint }}</span>@endif</span>
    @endif
</label>
