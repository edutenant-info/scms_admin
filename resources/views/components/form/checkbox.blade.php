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
    $isChecked = old($name, $checked) ? true : false;
@endphp

<label {{ $attributes->class(['ckb', 'disabled' => $disabled]) }}>
    <input
        type="checkbox"
        name="{{ $name }}"
        value="{{ $value }}"
        @if($id) id="{{ $id }}" @endif
        @checked($isChecked)
        @disabled($disabled)
    >
    @if($label)
        <span>{{ $label }}@if($hint)<span class="ckb-hint">{{ $hint }}</span>@endif</span>
    @endif
</label>
