@props([
    'name',
    'label' => null,
    'options' => [],            // assoc [value => label] | list of scalars | list of ['value'=>,'label'=>]
    'selected' => null,         // scalar value, or array when multiple
    'placeholder' => 'Select…',
    'multiple' => false,
    'disabled' => false,
    'required' => false,
    'search' => true,           // false → hide select2 search box
    'allowClear' => false,      // show an "×" to clear the single selection
    'id' => null,
    'hint' => null,
])

@php
    // Normalise the various accepted option shapes into [['value'=>, 'label'=>], …].
    $normalized = [];
    foreach ($options as $key => $opt) {
        if (is_array($opt)) {
            $normalized[] = ['value' => $opt['value'] ?? $key, 'label' => $opt['label'] ?? ($opt['value'] ?? $key)];
        } elseif (is_int($key)) {
            $normalized[] = ['value' => $opt, 'label' => $opt];
        } else {
            $normalized[] = ['value' => $key, 'label' => $opt];
        }
    }

    // Resolve the selected value(s), honouring old() input first.
    $current = old($name, $selected);
    $selectedValues = array_map('strval', $multiple ? (array) ($current ?? []) : [$current]);

    $fieldId = $id ?? 'sel-' . \Illuminate\Support\Str::slug($name, '-') . '-' . \Illuminate\Support\Str::random(4);
    $hasError = $errors->has($multiple ? $name . '.*' : $name) || $errors->has($name);
@endphp

<select
    {{ $attributes->class(['fs']) }}
    id="{{ $fieldId }}"
    name="{{ $multiple ? $name . '[]' : $name }}"
    data-placeholder="{{ $placeholder }}"
    data-search="{{ $search ? 'true' : 'false' }}"
    @if($allowClear) data-allow-clear="true" @endif
    @if($multiple) multiple @endif
    @disabled($disabled)
    @required($required)
>
    @unless($multiple)
        <option value="">{{ $placeholder }}</option>
    @endunless
    @foreach($normalized as $opt)
        <option value="{{ $opt['value'] }}" @selected(in_array((string) $opt['value'], $selectedValues, true))>{{ $opt['label'] }}</option>
    @endforeach
</select>
